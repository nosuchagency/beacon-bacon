<?php

namespace App\Http\Controllers\API\V2;

use App\Beacon;
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        return response(Beacon::create($request->all()), 201);
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
        $beacon = Beacon::findOrFail($id);

        return $this->attachResources($request, $beacon);
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

        $beacon = Beacon::findOrFail($id);

        $beacon->update($request->all());

        return $beacon;
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
        $beacon = Beacon::findOrFail($id)->delete();

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
