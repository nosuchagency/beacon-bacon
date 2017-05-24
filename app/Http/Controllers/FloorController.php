<?php

namespace App\Http\Controllers;

use Image;
use App\Floor;
use App\Place;
use App\Http\Requests;
use Illuminate\Http\Request;

class FloorController extends Controller
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
    public function index($placeId)
    {
        $floors = Floor::all();
        $place = Place::findOrFail($placeId);
        return view('floors.index', compact('floors', 'place', 'placeId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($placeId)
    {
        $place = Place::findOrFail($placeId);
        return view('floors.create', compact('place', 'placeId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $placeId)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
           'order' => 'required|numeric',
           'map_height_in_centimeters' => 'required|numeric',
           'map_width_in_centimeters' => 'required|numeric',           
           'image' => 'required|image',
        ]);

        $floor = Floor::create($request->except('image'));

        $this->uploadFloor($floor, $request);

        return redirect()->route('floors.show', [$placeId, $floor->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($placeId, $id)
    {
        $floor = Floor::findOrFail($id);

        if ($floor->image) {
            $path = $floor->getPhysicalIconPath();
            $image = Image::make($path);
            $floor->mapWidth = $image->width();
            $floor->mapHeight = $image->height();
        }

        return view('floors.show', compact('floor', 'placeId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($placeId, $id)
    {
        $floor = Floor::findOrFail($id);

        return view('floors.edit', compact('floor', 'placeId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $placeId, $id)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
           'order' => 'required|numeric',
           'map_height_in_centimeters' => 'required|numeric',
           'map_width_in_centimeters' => 'required|numeric',
           'image' => 'image',
        ]);

        $floor = Floor::findOrFail($id);
        $floor->update($request->except('image'));

        $this->uploadFloor($floor, $request);

        return redirect()->route('floors.show', [$placeId, $id]);
    }

    /**
     * Get the specified image resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function image($id)
    {
        $floor = Floor::findOrFail($id);

        return response()->file($floor->getPhysicalIconPath());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($placeId, $id)
    {
        $floor = Floor::findOrFail($id);
        $floor->locations()->delete();
        $floor->delete();

        return redirect()->route('places.show', $placeId);
    }

    /**
     * Upload image
     * @param  Floor $floor
     * @param  Request  $request
     * @return void
     */
    protected function uploadFloor(Floor $floor, Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }

        $request->file('image')->store('images/floors/' . $floor->id);
        $fileName = $request->image->hashName();
        $destinationPath = storage_path() . '/app/images/floors/' . $floor->id;

        /*$destinationPath = public_path('uploads/floors/' . $floor->id);
        $fileName = $request->file('image')->getClientOriginalName();*/

        if ($floor->image && is_file($destinationPath . '/' . $floor->image) && $fileName != $floor->image) {
            unlink($destinationPath . '/' . $floor->image);
        }

        //$request->file('image')->move($destinationPath, $fileName);
        
        $image = Image::make($destinationPath . '/' . $fileName);
        $image->save( $destinationPath . '/original-' . $fileName );
        $map_pixel_to_centimeter_ratio = round( $image->width() / $floor->map_width_in_centimeters, 2 );

        $floor->update([
            'image' => $fileName,
            'map_height_in_pixels' => $image->height(),
            'map_width_in_pixels' => $image->width(),
            'map_pixel_to_centimeter_ratio' => $map_pixel_to_centimeter_ratio
        ]);
    }
}
