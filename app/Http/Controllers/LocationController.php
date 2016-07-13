<?php

namespace App\Http\Controllers;

use App\Map;
use App\Place;
use App\Category;
use App\Location;
use App\Http\Requests;
use Illuminate\Http\Request;

class LocationController extends Controller
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
    public function index($placeId, $mapId)
    {
        $locations = Location::all();
        $place = Place::findOrFail($placeId);
        $map = Map::findOrFail($mapId);
        return view('locations.index', compact('locations', 'place', 'map', 'placeId', 'mapId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($placeId, $mapId)
    {
        $categories = Category::lists('name', 'id');
        $place = Place::findOrFail($placeId);
        $map = Map::findOrFail($mapId);
        return view('locations.create', compact('categories', 'place', 'map', 'placeId', 'mapId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $placeId, $mapsId)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
        ]);

        $location = Location::create($request->all());
        return redirect()->route('locations.show', [$placeId, $mapsId, $location->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($placeId, $mapId, $id)
    {
        $location = Location::findOrFail($id);
        return view('locations.show', compact('location', 'placeId', 'mapId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($placeId, $mapId, $id)
    {
        $location = Location::findOrFail($id);
        $places = Place::lists('name', 'id');
        $categories = Category::lists('name', 'id');
        $maps = Map::lists('name', 'id');
        return view('locations.edit', compact('location', 'places', 'categories', 'maps', 'placeId', 'mapId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $placeId, $mapId, $id)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
        ]);

        $location = Location::findOrFail($id);
        $location->update($request->all());
        return redirect()->route('maps.show', [$placeId, $mapId]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($placeId, $mapId, $id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
        return redirect()->route('maps.show', [$placeId, $mapId]);
    }
}
