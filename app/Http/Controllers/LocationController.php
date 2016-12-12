<?php

namespace App\Http\Controllers;

use Image;
use App\Floor;
use App\Place;
use App\Poi;
use App\Beacon;
use App\Block;
use App\Findable;
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
	    //TODO -> redirect to floor show?
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

		if ( $type == 'beacon' ) {

	        $beacons = Beacon::where( 'location_id', 0 )->lists('name', 'id');

			    $beacons_select = [];
			    $beacons_select[0] = 'Select Beacon...';

	        $beacons = Beacon::where( 'location_id', 0 )->get();
			foreach( $beacons as $beacon ) {
				$beacons_select[ $beacon->id ] = $beacon->name . ' (' . $beacon->major . ' : ' . $beacon->minor . ')';
			}

			return view('locations.create.beacon', compact('beacons_select', 'place', 'floor', 'placeId', 'floorId'));
		}

		if ( $type == 'findable' ) {

	        $findables = Findable::lists( 'name', 'id' );
			$findables->prepend( 'Select type...', 0 );

			return view('locations.create.findable', compact('findables', 'place', 'floor', 'placeId', 'floorId'));
		}

		if ( $type == 'block' ) {

	        $blocks = Block::lists( 'name', 'id' );
			$blocks->prepend( 'Select block...', 0 );

	        $findables = Findable::lists( 'name', 'id' );
			$findables->prepend( 'Is this block findable?', 0 );

			return view('locations.create.block', compact('blocks','findables','place', 'floor', 'placeId', 'floorId'));
		}

        $pois = Poi::lists( 'name', 'id' );
		$pois->prepend( 'Select POI...', 0 );

		return view('locations.create.poi', compact('pois', 'place', 'floor', 'placeId', 'floorId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $placeId, $floorId)
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

        return redirect()->route('locations.edit', [$placeId, $floorId, $location->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($placeId, $floorId, $id)
    {
        return redirect()->route('locations.edit', [$placeId, $floorId, $id]);
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

        if ($location->floor->image) {
            $image = Image::make($location->floor->image);
            $location->mapWidth = $image->width();
            $location->mapHeight = $image->height();
        }

        $location->mapWidthCentimeters = $floor->map_width_in_centimeters;
        $location->mapHeightCentimeters = $floor->map_height_in_centimeters;

		if ( $location->type == 'beacon' ) {
			$beacons_select = [];
	        $beacons = Beacon::where( 'location_id', 0 )->get();
			foreach( $beacons as $beacon ) {
				$beacons_select[ $beacon->id ] = $beacon->name . ' (' . $beacon->major . ' : ' . $beacon->minor . ')';
			}

			$beacons_select[ $location->beacon->id ] = $location->beacon->name . ' (' . $location->beacon->major . ' : ' . $location->beacon->minor . ')';

			return view('locations.edit.beacon', compact('beacons_select','location', 'placeId', 'floorId'));
		}

		if ( $location->type == 'findable' ) {

	        $findables = Findable::lists( 'name', 'id' );
			$findables->prepend( 'Select type...', 0 );

			return view('locations.edit.findable', compact('findables','location', 'placeId', 'floorId'));
		}

		if ( $location->type == 'block' ) {

	        $blocks = Block::lists( 'name', 'id' );
			$blocks->prepend( 'Select Block...', 0 );

	        $findables = Findable::lists( 'name', 'id' );
			$findables->prepend( 'Is findable?', 0 );

	        if ($location->block->image) {
	            $image = Image::make($location->block->image);
	            $location->imageWidth = $image->width();
	            $location->imageHeight = $image->height();
	        }

	        $location->imageRotation = deg2rad( $location->rotation );

			return view('locations.edit.block', compact('blocks','findables','location','placeId','floor','floorId'));
		}

        $pois = Poi::lists( 'name', 'id' );

        if ($location->poi->icon) {
            $icon = Image::make($location->poi->icon);

            $location->iconWidth = 32;
            $location->iconHeight = round( 32 / $icon->width() * $icon->height() );
        }

		if ( $location->poi->type == 'area' ) {
			return view('locations.edit.poi.area', compact('pois','location', 'placeId', 'floorId'));
		}

		return view('locations.edit.poi.icon', compact('pois','location', 'placeId', 'floorId'));
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

		if ( $location->type == 'beacon' ) {
			$beacon = Beacon::where( 'location_id', '=', $location->id )->first();
			$beacon->place_id = 0;
			$beacon->floor_id = 0;
			$beacon->location_id = 0;
			$beacon->save();
		}

        $beacon_id = $request->input('beacon_id');
        if ( ! empty( $beacon_id ) ) {
	        $beacon = Beacon::findOrFail($beacon_id);
	        $beacon->place_id = $request->input('place_id');
	        $beacon->floor_id = $request->input('floor_id');
	        $beacon->location_id = $location->id;
	        $beacon->save();
        }

        $location->update($request->all());

   		if ( $location->type == 'block' ) {
	   		$this->createFloorMap( $location );
	   	}

        return redirect()->route('floors.show', [$placeId, $floorId]);
    }

    private function createFloorMap ( Location $location ) {
      $locations = $location->floor->locations;
      $floorImage = Image::make( public_path( 'uploads/floors/' . $location->floor->id . '/original-' . basename( $location->floor->image ) ) );

      foreach( $locations as $location ) {
        if ( $location->type != 'block' || empty( $location->block->image ) ) {
          continue;
        }

        try {
          $blockImage = Image::make( $location->block->image );
          $blockImage->rotate( -$location->rotation );
          $floorImage->insert( $blockImage, 'top-left', round( $location->posX - ( $blockImage->width() / 2 ) ), round( $location->posY - ( $blockImage->height() / 2 ) ) );
        }
        catch( \Exception $e) {
        }
      }

      $floorImage->save( base_path( 'public/uploads/floors/' . $location->floor->id . '/' . basename( $location->floor->image ) ) );
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
