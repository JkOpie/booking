<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemAttachment;
use App\Models\Type;
use App\Mail\SendNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ItemUser;
use Illuminate\Support\Facades\Mail;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.item.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $categories = Category::all();
        return view('admin.item.create',compact('types', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Item::firstOrCreate([
            'name' => $request->name,
            'description' => $request->description,
            'type_id' => $request->type_id,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'price' => $request->price,
            // 'state' => $request->state,
            // 'city' => $request->city
        ]);

        if($request->file('attachment')){
            foreach ($request->file('attachment') as $key => $attachment) {
                # code...
                $fileName = time().'.'.$attachment->extension();
                $attachment->move(public_path('uploads'), $fileName);

                ItemAttachment::firstOrCreate([
                    'items_id' => $item->id,
                    'filename_original' => $attachment->getClientOriginalName(),
                    'filename' => $fileName,
                ]);
            }
        }



        return redirect()->route('items.index')->with('success', $request->name.' '.'created successfully');
    }



    public function admin_update(Request $request)
    {
        //dd( $request->all());
        $item = ItemUser::where('id', $request->item_id)->firstOrFail();

        if($request['status'] != 'rejected'){
            $message = 'Admin '.Auth::user()->name.' have '.$request['status'] .' you from '.$item->item->name;
            //Mail::to($item->user->email)->send(new SendNotifications($message));
            $item->update(['status' => $request['status'] ]);
            return redirect()->back()->with('success',$item->item->name.' updated to '.$request['status'].'');
        }else{
            $message = 'Admin '.Auth::user()->name.' have removed you from '.$item->item->name;
            //Mail::to($item->user->email)->send(new SendNotifications($message));
            $item->delete();
            return redirect()->back()->with('success',$item->item->name.' updated to available');
        }
    }

    public function confirmed($id)
    {
        $item = Item::where('id', $id)->firstOrFail();

        $item->update([
            'user_id' => Auth::user()->id,
            'status' => 'booked',
        ]);

        return redirect()->back()->with('success',$item->name.' ! Please confirm your booking in booking page');
    }

    public function search(Request $request)
    {
        $items = Item::where('name', 'like', '%'.$request->title.'%')->get();

        if($items->count() == 0){
            return redirect()->back()->with('error', 'Cant find any place your search, Please try again');
        }
        return view('search',compact('items'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($type_id,$category_id)
    {
        $category = Category::findOrFail($category_id);
        $items = Item::where(['type_id'=>$type_id,'category_id'=>$category_id])->where('status','available')->get();
        return view('view', compact('items','category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::where('id', $id)->with('attachments')->first();
        //dd($item);
        $types = Type::all();
        $categories = Category::all();
        return view('admin.item.edit', compact('item','types', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item =  Item::where('id', $id)->first();

        if(!$request->file('attachment')){

            $item->update([
                'name' => $request->name,
                'description' => $request->description,
                'type_id' => $request->type_id,
                'category_id' => $request->category_id,
                'status' => $request->status,
                'price' => $request->price,
                // 'state' => $request->state,
                // 'city' => $request->city
            ]);

        }else{
            foreach ($request->file('attachment') as $key => $attachment) {
                # code...
                $fileName = time().'.'.$attachment->extension();
                $attachment->move(public_path('uploads'), $fileName);

                ItemAttachment::firstOrCreate([
                    'items_id' => $item->id,
                    'filename_original' => $attachment->getClientOriginalName(),
                    'filename' => $fileName,
                ]);
            }
        }

        return redirect()->route('items.edit', $item->id)->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        ItemUser::where('item_id', $item->id)->delete();
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Deleted successfully');
    }

    public function delete_attachment($item_id)
    {
        ItemAttachment::findOrFail($id)->delete();
        return redirect()->route('items.edit', $item->id)->with('success', 'Attachment deleted successfully');
    }
}
