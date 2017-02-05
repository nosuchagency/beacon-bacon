<?php

namespace App\Http\Controllers;

use Image;
use App\Poi;
use App\Http\Requests;
use Illuminate\Http\Request;

class PoiController extends Controller
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
        $pois = Poi::all();
        return view('pois.index', compact('pois'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = array('icon' => 'Icon', 'area' => 'Area');

        return view('pois.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'internal_name' => 'required|max:255',
        ]);

        $poi = Poi::create($request->except('icon'));

        $this->uploadIcon($poi, $request);

        return redirect()->route('pois.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poi = Poi::findOrFail($id);
        return view('pois.show', compact('poi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poi = Poi::findOrFail($id);
        $types = array('icon' => 'Icon', 'area' => 'Area');

        return view('pois.edit', compact('poi', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'internal_name' => 'required|max:255',
        ]);

        $poi = Poi::findOrFail($id);
        $poi->update($request->except('icon'));

        $this->uploadIcon($poi, $request);

        return redirect()->route('pois.index');
    }

    /**
     * Get the specified image resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function image($id)
    {
        $poi = Poi::findOrFail($id);

        return Image::make($poi->getPhysicalIconPath())->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poi = Poi::findOrFail($id);
        $poi->delete();

        return redirect()->route('pois.index');
    }

    /**
     * Upload icon
     * @param  Poi $Poi
     * @param  Request $request
     * @return void
     */
    protected function uploadIcon(Poi $poi, Request $request)
    {
        if (!$request->hasFile('icon')) {
            return;
        }
        $request->file('icon')->store('pois/' . $poi->id);
        $fileName = $request->icon->hashName();
        $destinationPath = storage_path() . '/app/pois/' . $poi->id;

        if ($poi->icon && is_file($destinationPath . '/' . $poi->icon)) {
            unlink($destinationPath . '/' . $poi->icon);
        }

        $poi->update([
            'icon' => $fileName
        ]);
    }
}
