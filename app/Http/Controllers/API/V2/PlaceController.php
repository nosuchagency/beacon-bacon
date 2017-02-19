<?php

namespace App\Http\Controllers\API\V2;

use App\Menu;
use App\Place;
use App\Poi;
use App\Location;
use App\Findable;
use File;
use Image;
use Illuminate\Http\Request;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use Cache;
use Carbon\Carbon;

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
        $request->request->add(array('activated' => 1));
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
     * Return a findable Location
     *
     * @param Request $request
     * @param int $id
     *
     * @return json
     */
    public function find(Request $request, $id)
    {
        $identifier = $request->find_identifier;
        if (empty($identifier)) {
            return response(['message' => 'missing parameter', 'parameter' => 'identifier'], 400);
        }
        $findable = Findable::where('identifier', $identifier)->first();
        if (empty($findable)) {
            return response(['message' => 'resource not found', 'resource' => 'findable'], 404);
        }

        $place = Place::findOrFail($id);

        $class = "BB\\" . $identifier . "Plugin\\" . $identifier . "Plugin";
        if (!class_exists($class)) {
            return response(['message' => 'resource not found', 'resource' => 'class'], 404);
        }
        $plugin = new $class;
        if (!method_exists($plugin, 'findable' . $identifier)) {
            return response(['message' => 'resource not found', 'resource' => 'method'], 404);
        }

        return $plugin->{'findable' . $identifier}($place, $findable, $request);
    }

    /**
     * Return a single item.
     *
     * @param Request $request
     * @param int $id
     *
     * @return json
     */
    public function show(Request $request, $id)
    {
        $place = Place::findOrFail($id);

        $place = $this->attachResources($request, $place);
        foreach ($place->floors as $floor) {

            $floor->image = url('api/v2/floors/' . $floor->id . '/image');

            foreach ($floor->locations as $location) {
                if ($location->poi_id > 0) {
                    $poi = Poi::find($location->poi_id);

                    if (!$poi) {
                        continue;
                    }

                    $poi->icon = url('api/v2/pois/' . $poi->id . '/icon');
                    $location->poi = $poi;
                } else {
                    $location->poi = null;
                }
            }

        }

        return $place;
    }

    /**
     * Update a single item.
     *
     * @param Request $request
     * @param int $id
     *
     * @return json
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $place = Place::findOrFail($id);

        $place->update($request->all());

        return $place;
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
        $place = Place::findOrFail($id)->delete();

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
        $menus = Menu::where('place_id', $id)->orderBy('order')->with('poi')->get();

        foreach($menus as $menu ) {
            if($menu->poi) {
                $menu->poi->icon = url('api/v2/pois/' . $menu->poi->id . '/icon');
            }
        }

        return $menus;
    }

}
