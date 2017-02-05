<?php

namespace App\Http\Controllers\API\V1;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
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
        return $this->filteredAndOrdered($request, new Location())->paginate($this->pageSize);
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

        return response(Location::create($request->all()), 201);
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
        $location = Location::find($id);

        if(!$location) {
            return response(['message' => 'Resource not found',], 404);
        }

        return $this->attachResources($request, $location);
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

        $location = Location::find($id);

        if(!$location) {
            return response(['message' => 'Resource not found',], 404);
        }

        $location->update($request->all());

        return $location;
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
        $location = Location::find($id);

        if(!$location) {
            return response(['message' => 'Resource not found',], 404);
        }

        $location->delete();

        return response('', 204);
    }

    /**
     * Return a list of deleted items.
     *
     * @return json
     */
    public function deleted()
    {
        return Location::onlyTrashed()->get();
    }
}
