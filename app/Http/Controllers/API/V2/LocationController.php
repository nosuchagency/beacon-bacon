<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Requests\LocationRequest;
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
     * @param LocationRequest $request
     *
     * @return json
     */
    public function store(LocationRequest $request)
    {
        return response(Location::create($request->all()), 201);
    }

    /**
     * Return a single item.
     *
     * @param Request $request
     * @param Location $location
     *
     * @return json
     */
    public function show(Request $request, Location $location)
    {
        return $this->attachResources($request, $location);
    }

    /**
     * Update a single item.
     *
     * @param LocationRequest $request
     * @param Location $location
     *
     * @return json
     */
    public function update(LocationRequest $request, Location $location)
    {
        if (!empty($request->value)) {
            $request->request->add(['name' => $request->value]);
        }

        $location->update($request->all());

        return $location;
    }

    /**
     * Delete a single item.
     *
     * @param Location $location
     *
     * @return empty
     */
    public function destroy(Location $location)
    {
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
