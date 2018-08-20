<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Requests\PoiRequest;
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
     * @param PoiRequest $request
     *
     * @return json
     */
    public function store(PoiRequest $request)
    {
        $poi = Poi::create($request->except('icon'));

        $this->uploadIcon($poi, $request);

        $poi->icon = url('api/v2/pois/' . $poi->id . '/icon');

        return response($poi, 201);
    }

    /**
     * Return a single item.
     *
     * @param Request $request
     * @param Poi $poi
     *
     * @return json
     */
    public function show(Request $request, Poi $poi)
    {
        $poi->icon = url('api/v2/pois/' . $poi->id . '/icon');

        return $this->attachResources($request, $poi);
    }

    /**
     * Update a single item.
     *
     * @param PoiRequest $request
     * @param Poi $poi
     *
     * @return json
     */
    public function update(PoiRequest $request, Poi $poi)
    {
        $poi->update($request->except('icon'));

        $this->uploadIcon($poi, $request);

        $poi->icon = url('api/v2/pois/' . $poi->id . '/icon');

        return $poi;
    }

    /**
     * Delete a single item.
     *
     * @param Poi $poi
     *
     * @return empty
     */
    public function destroy(Poi $poi)
    {
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
