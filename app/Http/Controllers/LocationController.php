<?php

namespace App\Http\Controllers;

use Image;
use App\Map;
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
        $pois = Poi::lists('name', 'id');
        $place = Place::findOrFail($placeId);
        $map = Map::findOrFail($mapId);
        return view('locations.create', compact('pois', 'place', 'map', 'placeId', 'mapId'));
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

        if ($location->poi->icon) {
            $icon = Image::make($location->poi->icon);
            $location->iconWidth = $icon->width();
            $location->iconHeight = $icon->height();
        }

        if ($location->map->image) {
            $image = Image::make($location->map->image);
            $location->mapWidth = $image->width();
            $location->mapHeight = $image->height();
        }

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
        $pois = Poi::lists('name', 'id');
        $maps = Map::lists('name', 'id');

        if ($location->poi->icon) {
            $icon = Image::make($location->poi->icon);
            $location->iconWidth = $icon->width();
            $location->iconHeight = $icon->height();
        }

        if ($location->map->image) {
            $image = Image::make($location->map->image);
            $location->mapWidth = $image->width();
            $location->mapHeight = $image->height();
        }

        return view('locations.edit', compact('location', 'places', 'pois', 'maps', 'placeId', 'mapId'));
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
