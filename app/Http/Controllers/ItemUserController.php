<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemUser;
use App\Models\Item;
use App\Mail\SendNotifications;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class ItemUserController extends Controller
{
    public function index(Request $request)
    {
        $itemuser = ItemUser::where('item_id', $request->id)
        //->whereDate('start_date', '>', Carbon::now()->toDateTimeString())
        ->with(['user', 'item'])->get();
        return $itemuser;
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $itemuser = ItemUser::where('id', $id)->update([
            'start_date' => Carbon::parse($request->start_date)->toDateTimeString(),
            'end_date' => Carbon::parse($request->end_date)->toDateTimeString(),
            'total_price' => $request->total_price
        ]);

        return redirect()->back()->with('success', 'Booking Updated!');
    }

    public function booking(Request $request, $id)
    {
        //dd($request->all());
        $item = Item::where('id', $id)->firstOrFail();
        $admin = User::select('*')->whereHas('roles', function($q){$q->where('name', 'admin');})->first();

        if($request->status == 'booked'){
            //dd(Auth::user()->id);
            $start_date = Carbon::parse($request->start_date)->toDateTimeString();
            $end_date = Carbon::parse($request->end_date)->toDateTimeString();

            if($end_date < $start_date ){
                return redirect('/user/places/'.$item->type_id.'/'.$item->category_id)->with('error','End date is greater than start date.');
            }

            $existingItem = ItemUser::where('item_id', $id)
            ->where(function ($q) use($start_date, $end_date) {
                    $q->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhereBetween('end_date', [$start_date, $end_date]);
                    // ->orWhere(function ($q) use($start_date, $end_date){
                    //         $q->where('start_date', '<', $start_date)
                    //         ->where('end_date', '>', $end_date);
                    //     });
                })
            ->whereIn('status', ['booked', 'confirmed', 'approved'])
            ->get();

            //dd();

            if($existingItem->count() == 0){

                ItemUser::create([
                    'user_id' => Auth::user()->id,
                    'item_id' => $id,
                    'status' => $request->status,
                    'start_date' => Carbon::parse($request->start_date)->toDateTimeString(),
                    'end_date' => Carbon::parse($request->end_date)->toDateTimeString(),
                    'total_price' => $request->total_price
                ]);

                if(Auth::user()->hasRole('user')){
                    $message = 'User '.Auth::user()->name.' has booked '.$item->name;
                    Mail::to(Auth::user()->email)->send(new SendNotifications($message));
                    return redirect('/user/booked')->with('success',$item->name.' booked! Please pay to confirm your booking in booking page');
                }

            }else{
                if(Auth::user()->hasRole('user')){
                    return redirect('/user/places/'.$item->type_id.'/'.$item->category_id)->with('error', 'Already booked on this date! Please select other data');
                }
            }
        }

        if($request->status == "confirmed"){

            $itemUser =  ItemUser::where('id', $request->itemUserID)->first();

            if($request->file('receipt')){
                $receipt = $request->file('receipt');
                $fileName = time().'.'.$receipt->extension();
                $receipt->move(public_path('receipts'), $fileName);

                $itemUser->update([
                    'receipt_original' => $receipt->getClientOriginalName(),
                    'receipt' => $fileName,
                ]);
            }

            $itemUser->update([
                'payment_type' => $request->payment_type,
                'status' => $request->status
            ]);

            if(Auth::user()->hasRole('user')){
                return redirect('/user/booked')->with('success',$item->name.' confirmed!');
            }
        }

        if($request->status == "approved"){
            $itemUser =  ItemUser::where('id', $id)->first();
            $itemUser->update([
                'status' => $request->status
            ]);

            if(Auth::user()->hasRole('admin')){
                $message = 'Admin '.Auth::user()->name.' has '.$request->status.' '.$item->name;
                Mail::to($itemUser->user->email)->send(new SendNotifications($message));
                return redirect('/user/booked')->with('success',$item->name.' confirmed!');
            }
        }

    }

    public function destroy($id)
    {
        $item = ItemUser::where('id', $id)->first();
        $admin = User::select('*')->whereHas('roles', function($q){$q->where('name', 'admin');})->first();

        $message = 'User '.Auth::user()->name.' has deleted '.$item->item->name;
        Mail::to($admin->email)->send(new SendNotifications($message));

        $item->delete();

        return redirect()->back()->with('success','Booking deleted!');
    }

    public function payment($itemuser_id)
    {
        $itemuser = ItemUser::where('id', $itemuser_id)->with(['item', 'user'])->firstOrFail();
        return view('payment', compact('itemuser'));
    }

    public function postPayment($itemuser_id){

        $itemuser = ItemUser::where('id', $itemuser_id)->update([
            'receipt_original' => strtotime(Carbon::now()),
            'status' => 'confirmed',
            'payment_type' => 'qr',
        ]);

        return true;
    }

    public function verifyPayment($itemuser_id){
        return ItemUser::where('id', $itemuser_id)->first()->status;
    }

    public function receipts($itemuser_id)
    {
        $data = ItemUser::where('id', $itemuser_id)->with(['item','user'])->first()->toArray();
        $pdf = Pdf::loadView('receipts', ["data" => $data]);
        return $pdf->stream();
    }
}
