<?php

namespace App\Http\Controllers;

use App\Findable;
use App\Http\Requests;
use Illuminate\Http\Request;

class FindableController extends Controller
{
    /**
     * Instantiate a new controller instance.
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
        $findables = Findable::all();
        return view('findable.index', compact('findables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('findable.create');
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
        ]);

        $findable = Findable::create($request->all());

        return redirect()->route('findables.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $findable = Findable::findOrFail($id);
        return view('findable.show', compact('findable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $findable = Findable::findOrFail($id);

        return view('findable.edit', compact('findable'));
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
        ]);

        $findable = Findable::findOrFail($id);
        $findable->update($request->all());

        return redirect()->route('findables.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $findable = Findable::findOrFail($id);
        $findable->delete();

        return redirect()->route('findables.index');
    }
}
