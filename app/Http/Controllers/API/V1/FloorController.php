<?php

namespace App\Http\Controllers\API\V1;

use App\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
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

        $floors = $this->filteredAndOrdered($request, new Floor())->paginate($this->pageSize);

        foreach ($floors->items() as $floor) {
            if ($floor->image) {
                $floor->image = $floor->getPublicImage();
            } else {
                $floor->image = null;
            }
        }

        return $floors;
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
            'image' => 'required|image',
        ]);

        return response(Floor::create($request->all()), 201);
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
        $floor = Floor::findOrFail($id);

        $floor->image = $floor->getPublicImage();

        return $this->attachResources($request, $floor);
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
            'name' => 'required|max:255',
            'image' => 'required|image',
        ]);

        $floor = Floor::findOrFail($id);

        $floor->update($request->all());

        return $floor;
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
        $floor = Floor::findOrFail($id)->delete();

        return response('', 204);
    }

    /**
     * Return a list of deleted items.
     *
     * @return json
     */
    public function deleted()
    {
        return Floor::onlyTrashed()->get();
    }
}
