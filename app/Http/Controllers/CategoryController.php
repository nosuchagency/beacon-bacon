<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Instantiate a new CategoryController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
           'internal_name' => 'required|max:255',
           'icon' => 'required|image',
        ]);

        $category = Category::create($request->except('icon'));

        $this->uploadIcon($category, $request);

        return redirect()->route('categories.show', $category->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
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
        return view('categories.edit', compact('category'));
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
        $this->validate($request, [
           'name' => 'required|max:255',
           'internal_name' => 'required|max:255',
           'icon' => 'required|image',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->except('icon'));

        $this->uploadIcon($category, $request);

        return redirect()->route('categories.index');
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
        $category->delete();
        return redirect()->route('categories.index');
    }

    /**
     * Upload icon
     * @param  Category $category
     * @param  Request  $request
     * @return void
     */
    protected function uploadIcon(Category $category, Request $request)
    {
        if (!$request->hasFile('icon')) {
            return;
        }

        $destinationPath = public_path('uploads/categories/' . $category->id);
        $fileName = $request->file('icon')->getClientOriginalName();

        if ($category->icon && is_file($destinationPath . '/' . $category->icon)) {
            unlink($destinationPath . '/' . $category->icon);
        }

        $request->file('icon')->move($destinationPath, $fileName);

        $category->update([
            'icon' => $fileName
        ]);
    }
}
