<?php

namespace App\Http\Controllers\API\V1;

use App\Menu;
use App\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Return a list of items.
     *
     * @param Request $request
     *
     * @return json
     */
    public function index(Request $request)
    {
        return $this->filteredAndOrdered($request, new Place())->paginate($this->pageSize);
    }

    /**
     * Save a new item.
     *
     * @param Request $request
     *
     * @return json
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
        ]);

        return response(Place::create($request->all()), 201);
    }

    /**
     * Return an IMS Location
     *
     * @param Request $request
     * @param int     $id
     *
     * @return json
     */
    public function find(Request $request, $id)
    {
        $place = Place::findOrFail($id);
        
        $request = Request::instance()->getContent();

        return $request;
    }

    /**
     * Return a single item.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return json
     */
    public function show(Request $request, $id)
    {
        $place = Place::findOrFail($id);

        return $this->attachResources($request, $place);
    }

    /**
     * Update a single item.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return json
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'name' => 'max:255',
        ]);

        $model = Place::findOrFail($id);
        $model->update($request->all());

        return $model;
    }

    /**
     * Delete a single item.
     *
     * @param int $id
     *
     * @return empty
     */
    public function destroy($id)
    {
        Place::findOrFail($id)->delete();

        return response('', 204);
    }

    /**
     * Return a list of deleted items.
     *
     * @return json
     */
    public function deleted()
    {
        return Place::onlyTrashed()->get();
    }

    /**
     * Get menu items.
     *
     * @param int $id
     *
     * @return json
     */
    public function menu($id)
    {
        return Menu::where('place_id', $id)->orderBy('order')->with('poi')->get();
    }
    
    /**
     * Find something...
     *
     * @param int $id
     *
     * @return json
     */
    public function find($id)
    {
        return Menu::orderBy('order')->with('poi')->get();
    }    
}
