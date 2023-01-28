<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'attachment' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fileName = time().'.'.$request->attachment->extension();
        $request->attachment->move(public_path('categories'), $fileName);

        Category::firstOrCreate([
            'name' => $request->name,
            'filename' => $fileName,
        ]);

        return redirect()->route('categories.index')->with('success', $request->name.' '.'created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
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
        // /dd($request->all());

        $category = Category::where('id', $id)->first();
        $fileName = null;

        // if(File::exists('uploads/'.$category->filename)) {
        //     File::delete('uploads/'.$category->filename);
        // }

        if($request->file('attachment')){
            $fileName = time().'.'.$request->attachment->extension();
            $request->attachment->move(public_path('categories'), $fileName);
        }

        $category->update([
            'name' => $request->name,
            'filename' =>  $fileName,
        ]);

        return redirect()->route('categories.index')->with('success', $category->name.' updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // if(File::exists('uploads/'.$category->filename)) {
        //     File::delete('uploads/'.$category->filename);
        // }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Deleted successfully');
    }
}
