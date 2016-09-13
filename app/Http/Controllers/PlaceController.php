<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Place;
use App\Poi;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Instantiate a new controller instance.
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
        $places = Place::all();

        return view('places.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('places.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
        ]);

        $place = Place::create($request->all());

        return redirect()->route('places.show', $place->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = Place::findOrFail($id);
        $menuitems = Menu::where('place_id', $id)->orderBy('order')->get();
        $pois = Poi::lists('name', 'id')->prepend('', '');

        return view('places.show', compact('place', 'menuitems', 'pois'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $place = Place::findOrFail($id);

        return view('places.edit', compact('place'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
        ]);

        $place = Place::findOrFail($id);
        $place->update($request->all());

        return redirect()->route('places.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = Place::findOrFail($id);
        $place->floors()->delete();
        $place->delete();

        return redirect()->route('places.index');
    }

    /**
     * Save a new menu item to database.
     *
     * @param Request $request
     * @param int     $placeId
     *
     * @return json
     */
    public function storeMenuItem(Request $request, $placeId)
    {
        $this->validate($request, [
            'poi' => 'required_if:type,poi',
            'title' => 'required_if:type,title',
        ]);

        Menu::create([
            'place_id' => $placeId,
            'poi_id' => $request->input('poi'),
            'title' => $request->input('title'),
        ]);

        return redirect()->route('places.show', $placeId);
    }

    /**
     * Update the order of menu items.
     *
     * @param Request $request
     * @param int     $placeId
     *
     * @return json
     */
    public function updateMenuOrder(Request $request, $placeId)
    {
        if ($request->has('menuitem')) {
            foreach ($request->menuitem as $index => $id) {
                Menu::findOrFail($id)->update(['order' => $index]);
            }

            return response()->json([
                'status' => 'ok',
            ]);
        }

        return response()->json([
            'status' => 'error',
        ]);
    }

    /**
     * Delete menu item.
     *
     * @param Request $request
     * @param int     $placeId
     *
     * @return json
     */
    public function destroyMenuItem(Request $request, $placeId)
    {
        if ($request->has('menuitem')) {
            $id = str_replace('menuitem-', '', $request->menuitem);

            Menu::findOrFail($id)->delete();

            return response()->json([
                'status' => 'ok',
            ]);
        }

        return response()->json([
            'status' => 'error',
        ]);
    }
}
