<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.profiles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->password != $request->confirm_password){
            return redirect()->back()->with('error', 'Pasword and Confirm Password not match, Please try again!');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
        ]);

        $user->assignRole('user');

        if($request->file('image')){
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('profiles'), $fileName);

            $user->update([
                'image' => $fileName
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.profiles.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd($id);
        $user = User::where('id', $id)->first();
        return view('admin.profiles.edit', compact('user'));
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
        //dd($request->all(), $id);
        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'User Information Updated');
    }

    public function update_password(Request $request, $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        //dd($request->all(), $id);
        if (Hash::check($request->previous_password, $user->password)) {
            // The passwords match...
            //dd('match');
            if($request->password == $request->confirm_password){

                User::where('id', $id)->update([
                    'password' => Hash::make($request->password)
                ]);

                return redirect()->back()->with('success', 'User Password Updated');
            }

            return redirect()->back()->with('error', 'Password or Confirm Password no same, Please try again.');
        }

        return redirect()->back()->with('error', 'Previous password not match, please try again');
    }

    public function update_image(Request $request, $id)
    {
        //dd($request->all(), $id);

        if($request->file('image')){
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('profiles'), $fileName);

            User::where('id', $id)->update([
                'image' => $fileName
            ]);
        }

        return redirect()->back()->with('success', 'User Image Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', 'User deleted');
    }
}
