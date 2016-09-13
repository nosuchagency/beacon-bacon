<?php

namespace App\Http\Controllers;

use Image;
use App\Floor;
use App\Place;
use App\Poi;
use App\Beacon;
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
    public function create ($placeId, $floorId, $type = 'poi')
    {
        $place = Place::findOrFail($placeId);
        $floor = Floor::findOrFail($floorId);

        $pois = Poi::lists( 'name', 'id' );
		$pois->prepend( 'Select POI...', 0 );
        
        $beacons = Beacon::where( 'location_id', 0 )->lists('name', 'id');
		$beacons->prepend( 'Select Beacon...', 0 );
        
		if ( $type == 'beacon' ) {
			return view('locations.create.beacon', compact('beacons', 'place', 'floor', 'placeId', 'floorId'));			
		}

		if ( $type == 'ims' ) {
			return view('locations.create.ims', compact('place', 'floor', 'placeId', 'floorId'));			
		}

		return view('locations.create.poi', compact('pois', 'place', 'floor', 'placeId', 'floorId'));			
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

        $location = Location::create( $request->all() );

        $beacon_id = $request->input('beacon_id');
        if ( ! empty( $beacon_id ) ) {
	        $beacon = Beacon::findOrFail($beacon_id);
	        $beacon->place_id = $request->input('place_id');	        
	        $beacon->floor_id = $request->input('floor_id');
	        $beacon->location_id = $location->id;
	        $beacon->save();
        }

        return redirect()->route('locations.edit', [$placeId, $floorsId, $location->id]);
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
        if ($location->floor->image) {
            $image = Image::make($location->floor->image);
            $location->mapWidth = $image->width();
            $location->mapHeight = $image->height();
        }
        
        if ( ! empty( $location->poi ) ) {

	        if ($location->poi->icon) {
	            $icon = Image::make($location->poi->icon);
	            $location->iconWidth = $icon->width();
	            $location->iconHeight = $icon->height();
	        }

			return view('locations.show.poi', compact('location', 'placeId', 'floorId'));
        }

        if ( ! empty( $location->beacon ) ) {

			return view('locations.show.beacon', compact('location', 'placeId', 'floorId'));
        }

		return view('locations.show.ims', compact('location', 'placeId', 'floorId'));        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($placeId, $floorId, $id)
    {
        $place = Place::findOrFail($placeId);
        $floor = Floor::findOrFail($floorId);
        $location = Location::findOrFail($id);

        $pois = Poi::lists( 'name', 'id' );
        $beacons = Beacon::where( 'location_id', 0 )->lists('name', 'id');

        if ($location->floor->image) {
            $image = Image::make($location->floor->image);
            $location->mapWidth = $image->width();
            $location->mapHeight = $image->height();
        }

        if ( ! empty( $location->poi ) ) {

	        if ($location->poi->icon) {
	            $icon = Image::make($location->poi->icon);
	            $location->iconWidth = $icon->width();
	            $location->iconHeight = $icon->height();
	        }

			if ( $location->poi->type == 'area' ) {
				return view('locations.edit.poi.area', compact('pois','location', 'placeId', 'floorId'));
			}

			return view('locations.edit.poi.icon', compact('pois','location', 'placeId', 'floorId'));
        }

        if ( ! empty( $location->beacon ) ) {
       		$beacons->prepend( $location->beacon->name, $location->beacon->id );

			return view('locations.edit.beacon', compact('beacons','location', 'placeId', 'floorId'));
        }
        
		return view('locations.edit.ims', compact('location', 'placeId', 'floorId'));        
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

        $beacon_id = $request->input('beacon_id');
        if ( ! empty( $beacon_id ) ) {
	        $beacon = Beacon::findOrFail($beacon_id);
	        $beacon->place_id = $request->input('place_id');	        
	        $beacon->floor_id = $request->input('floor_id');
	        $beacon->save();
        }

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
		
		if ( $location->type == 'beacon' ) {
			$beacon = Beacon::where( 'location_id', '=', $location->id )->first();
			$beacon->place_id = 0;			
			$beacon->floor_id = 0;
			$beacon->location_id = 0;			
			$beacon->save();
		}
        
        $location->delete();

        return redirect()->route('floors.show', [$placeId, $floorId]);
    }
}
