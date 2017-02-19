<?php

namespace App\Http\Controllers\API\V1;

use App\Poi;
use Illuminate\Http\Request;

class PoiController extends Controller
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
        $pois = $this->filteredAndOrdered($request, new Poi())->paginate($this->pageSize);

        foreach ($pois->items() as $poi) {
            if ($poi->icon) {
                $poi->icon = $poi->getPublicImage();
            } else {
                $poi->icon = null;
            }
        }

        return $pois;
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
            'internal_name' => 'required|max:255',
            'icon' => 'required|image',
        ]);

        return response(Poi::create($request->all()), 201);
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
        $poi = Poi::findOrFail($id);

        $poi->icon = $poi->getPublicImage();

        return $this->attachResources($request, $poi);
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
            'internal_name' => 'required|max:255',
            'icon' => 'required|image',
        ]);

        $poi = Poi::findOrFail($id);

        $poi->update($request->all());

        return $poi;
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
        $poi = Poi::findOrFail($id)->delete();

        return response('', 204);
    }

    /**
     * Return a list of deleted items.
     *
     * @return json
     */
    public function deleted()
    {
        return Poi::onlyTrashed()->get();
    }
}
