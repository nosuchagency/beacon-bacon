<?php

namespace App\Http\Controllers;

use Image;
use App\Floor;
use App\Place;
use App\Poi;
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
    public function index($placeId, $floorId)
    {
        $locations = Location::all();
        $place = Place::findOrFail($placeId);
        $floor = Floor::findOrFail($floorId);
        return view('locations.index', compact('locations', 'place', 'floor', 'placeId', 'floorId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($placeId, $floorId)
    {
        $pois = Poi::lists('name', 'id');
        $place = Place::findOrFail($placeId);
        $floor = Floor::findOrFail($floorId);
        return view('locations.create', compact('pois', 'place', 'floor', 'placeId', 'floorId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $placeId, $floorsId)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
        ]);

        $location = Location::create($request->all());
        return redirect()->route('locations.show', [$placeId, $floorsId, $location->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($placeId, $floorId, $id)
    {
        $location = Location::findOrFail($id);

        if ($location->poi->icon) {
            $icon = Image::make($location->poi->icon);
            $location->iconWidth = $icon->width();
            $location->iconHeight = $icon->height();
        }

        if ($location->floor->image) {
            $image = Image::make($location->floor->image);
            $location->floorWidth = $image->width();
            $location->floorHeight = $image->height();
        }

        return view('locations.show', compact('location', 'placeId', 'floorId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($placeId, $floorId, $id)
    {
        $location = Location::findOrFail($id);
        $places = Place::lists('name', 'id');
        $pois = Poi::lists('name', 'id');
        $floors = Floor::lists('name', 'id');

        if ($location->poi->icon) {
            $icon = Image::make($location->poi->icon);
            $location->iconWidth = $icon->width();
            $location->iconHeight = $icon->height();
        }

        if ($location->floor->image) {
            $image = Image::make($location->floor->image);
            $location->floorWidth = $image->width();
            $location->floorHeight = $image->height();
        }

        return view('locations.edit', compact('location', 'places', 'pois', 'floors', 'placeId', 'floorId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $placeId, $floorId, $id)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
        ]);

        $location = Location::findOrFail($id);
        $location->update($request->all());
        return redirect()->route('floors.show', [$placeId, $floorId]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($placeId, $floorId, $id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
        return redirect()->route('floors.show', [$placeId, $floorId]);
    }
}
