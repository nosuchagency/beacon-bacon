<?php

namespace App\Http\Controllers;

use App\Map;
use App\Place;
use App\Http\Requests;
use Illuminate\Http\Request;

class MapController extends Controller
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
        $maps = Map::all();
        $place = Place::findOrFail($placeId);
        return view('maps.index', compact('maps', 'place', 'placeId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($placeId)
    {
        $place = Place::findOrFail($placeId);
        return view('maps.create', compact('place', 'placeId'));
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
           'image' => 'required|image',
        ]);

        $map = Map::create($request->except('image'));

        $this->uploadMap($map, $request);

        return redirect()->route('maps.show', [$placeId, $map->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($placeId, $id)
    {
        $map = Map::findOrFail($id);
        return view('maps.show', compact('map', 'placeId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($placeId, $id)
    {
        $map = Map::findOrFail($id);
        return view('maps.edit', compact('map', 'placeId'));
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
           'image' => 'image',
        ]);

        $map = Map::findOrFail($id);
        $map->update($request->except('image'));

        $this->uploadMap($map, $request);

        return redirect()->route('maps.show', [$placeId, $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($placeId, $id)
    {
        $map = Map::findOrFail($id);
        $map->delete();
        return redirect()->route('places.show', $placeId);
    }

    /**
     * Upload image
     * @param  Map $map
     * @param  Request  $request
     * @return void
     */
    protected function uploadMap(Map $map, Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }

        $destinationPath = public_path('uploads/maps/' . $map->id);
        $fileName = $request->file('image')->getClientOriginalName();

        if ($map->image && is_file($destinationPath . '/' . $map->image)) {
            unlink($destinationPath . '/' . $map->image);
        }

        $request->file('image')->move($destinationPath, $fileName);

        $map->update([
            'image' => $fileName
        ]);
    }
}
