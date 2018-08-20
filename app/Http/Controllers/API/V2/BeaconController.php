<?php

namespace App\Http\Controllers\API\V2;

use App\Beacon;
use App\Http\Requests\BeaconRequest;
use Illuminate\Http\Request;

class BeaconController extends Controller
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
        return $this->filteredAndOrdered($request, new Beacon())->paginate($this->pageSize);
    }

    /**
     * Save a new item.
     *
     * @param Request $request
     *
     * @return json
     */
    public function store(BeaconRequest $request)
    {
        return response(Beacon::create($request->all()), 201);
    }

    /**
     * Return a single item.
     *
     * @param Request $request
     * @param Beacon $beacon
     *
     * @return json
     */
    public function show(Request $request, Beacon $beacon)
    {
        return $this->attachResources($request, $beacon);
    }

    /**
     * Update a single item.
     *
     * @param BeaconRequest $request
     * @param Beacon $beacon
     *
     * @return json
     */
    public function update(BeaconRequest $request, Beacon $beacon)
    {
        $beacon->update($request->all());

        return $beacon;
    }

    /**
     * Delete a single item.
     *
     * @param Beacon $beacon
     *
     * @return empty
     */
    public function destroy(Beacon $beacon)
    {
        $beacon->delete();

        return response('', 204);
    }

    /**
     * Return a list of deleted items.
     *
     * @return json
     */
    public function deleted()
    {
        return Beacon::onlyTrashed()->get();
    }
}
