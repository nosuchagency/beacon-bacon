<?php

namespace App\Http\Controllers\API\V2;

use File;
use Image;
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
                $poi->icon = url('api/v2/pois/' . $poi->id . '/icon');
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
            'icon' => 'required|imageable',
        ]);

        $poi = Poi::create($request->except('icon'));

        $this->uploadIcon($poi, $request);

        $poi->icon = url('api/v2/pois/' . $poi->id . '/icon');

        return response($poi, 201);
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
        $poi = Poi::find($id);

        if (!$poi) {
            return response(['message' => 'Resource not found',], 404);
        }

        $poi->icon = url('api/v2/pois/' . $poi->id . '/icon');

        return $this->attachResources($request, $poi);
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
            'name' => 'max:255',
            'internal_name' => 'max:255',
            'icon' => 'required|imageable',
        ]);

        $poi = Poi::find($id);

        if (!$poi) {
            return response(['message' => 'Resource not found',], 404);
        }

        $poi->update($request->except('icon'));

        $this->uploadIcon($poi, $request);

        $poi->icon = url('api/v2/pois/' . $poi->id . '/icon');

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
        $poi = Poi::find($id);

        if (!$poi) {
            return response(['message' => 'Resource not found',], 404);
        }

        $poi->delete();

        return response('', 204);
    }

    /**
     * Return a list of deleted items.
     *
     * @return json
     */
    public function deleted()
    {
        $pois = Poi::onlyTrashed()->get();

        return $pois;
    }

    protected function uploadIcon(Poi $poi, Request $request)
    {
        $destinationPath = storage_path() . '/app/images/pois/' . $poi->id;

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath);
        }

        $image = Image::make($request->icon);

        $fileName = md5($request->icon . str_random(40)) . '.' . substr($image->mime, strpos($image->mime, "/") + 1);

        $file = storage_path() . '/app/images/pois/' . $poi->id . '/' . $fileName;

        $image->save($file);

        if ($poi->icon && is_file($destinationPath . '/' . $poi->icon)) {
            unlink($destinationPath . '/' . $poi->icon);
        }

        $poi->update([
            'icon' => $fileName
        ]);
    }
}
