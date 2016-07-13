<?php

namespace App\Http\Controllers;

use App\Map;
use App\Place;
use App\Beacon;
use App\Http\Requests;
use Illuminate\Http\Request;

class BeaconController extends Controller
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
        $beacons = Beacon::all();
        return view('beacons.index', compact('beacons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $places = Place::lists('name', 'id');
        $maps = Map::lists('name', 'id');
        return view('beacons.create', compact('places', 'maps'));
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
        ]);

        $beacon = Beacon::create($request->all());
        return redirect()->route('beacons.show', $beacon->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $beacon = Beacon::findOrFail($id);
        return view('beacons.show', compact('beacon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $beacon = Beacon::findOrFail($id);
        $places = Place::lists('name', 'id');
        $maps = Map::lists('name', 'id');
        return view('beacons.edit', compact('beacon', 'places', 'maps'));
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
        ]);

        $beacon = Beacon::findOrFail($id);
        $beacon->update($request->all());
        return redirect()->route('beacons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $beacon = Beacon::findOrFail($id);
        $beacon->delete();
        return redirect()->route('beacons.index');
    }
}
