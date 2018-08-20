<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Requests\FindMaterialRequest;
use App\Http\Requests\PlaceRequest;
use App\Menu;
use App\Place;
use App\Poi;
use App\Findable;
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
        $request->request->add(['activated' => 1]);
        return $this->filteredAndOrdered($request, new Place())->paginate($this->pageSize);
    }

    /**
     * Save a new item.
     *
     * @param PlaceRequest $request
     *
     * @return json
     */
    public function store(PlaceRequest $request)
    {
        return response(Place::create($request->all()), 201);
    }

    /**
     * Return a findable Location
     *
     * @param FindMaterialRequest $request
     * @param Place $place
     *
     * @return json
     */
    public function find(FindMaterialRequest $request, Place $place)
    {
        $identifier = $request->input('find_identifier');

        $findable = Findable::where('identifier', $identifier)->first();

        $class = 'BB\\' . $identifier . 'Plugin\\' . $identifier . 'Plugin';

        if (!class_exists($class)) {
            return response(['message' => 'resource not found', 'resource' => 'class'], 404);
        }

        $plugin = new $class;

        if (!is_callable([$plugin, 'findable' . $identifier])) {
            return response(['message' => 'resource not found', 'resource' => 'method'], 404);
        }

        return $plugin->{'findable' . $identifier}($place, $findable, $request);
    }

    /**
     * Return a single item.
     *
     * @param Request $request
     * @param Place $place
     *
     * @return json
     */
    public function show(Request $request, Place $place)
    {
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
     * @param PlaceRequest $request
     * @param Place $place
     *
     * @return json
     */
    public function update(PlaceRequest $request, Place $place)
    {
        $place->update($request->all());

        return $place;
    }

    /**
     * Delete a single item.
     *
     * @param Place $place
     *
     * @return empty
     */
    public function destroy(Place $place)
    {
        $place->delete();

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

        foreach ($menus as $menu) {
            if (!empty($menu->poi) && !empty($menu->poi->icon)) {
                $menu->poi->icon = url('api/v2/pois/' . $menu->poi->id . '/icon');
            }
        }

        return $menus;
    }

}
