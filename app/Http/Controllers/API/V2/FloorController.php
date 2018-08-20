<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Requests\FloorRequest;
use File;
use Image;
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
                $floor->image = url('api/v2/floors/' . $floor->id . '/image');
            } else {
                $floor->image = null;
            }
        }

        return $floors;
    }

    /**
     * Save a new item.
     *
     * @param FloorRequest $request
     *
     * @return json
     */
    public function store(FloorRequest $request)
    {
        $floor = Floor::create($request->except('image'));

        $this->uploadFloor($floor, $request);

        return response($floor, 201);
    }

    /**
     * Return a single item.
     *
     * @param Request $request
     * @param Floor $floor
     *
     * @return json
     */
    public function show(Request $request, Floor $floor)
    {
        $floor->image = url('api/v2/floors/' . $floor->id . '/image');

        return $this->attachResources($request, $floor);
    }

    /**
     * Update a single item.
     *
     * @param FloorRequest $request
     * @param Floor $floor
     *
     * @return json
     */
    public function update(FloorRequest $request, Floor $floor)
    {
        $floor->update($request->except('image'));

        $this->uploadFloor($floor, $request);

        return $floor;
    }

    /**
     * Delete a single item.
     *
     * @param Floor $floor
     *
     * @return empty
     */
    public function destroy(Floor $floor)
    {
        $floor->delete();

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

    protected function uploadFloor(Floor $floor, Request $request)
    {
        $destinationPath = storage_path() . '/app/images/floors/' . $floor->id;

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath);
        }

        $image = Image::make($request->image);

        $fileName = md5($request->image) . '.' . substr($image->mime, strpos($image->mime, "/") + 1);

        $file = storage_path() . '/app/images/floors/' . $floor->id . '/' . $fileName;

        $image->save($file);

        if ($floor->image && is_file($destinationPath . '/' . $floor->image)) {
            unlink($destinationPath . '/' . $floor->image);
        }

        $image = Image::make($destinationPath . '/' . $fileName);
        $image->save($destinationPath . '/original-' . $fileName);
        $map_pixel_to_centimeter_ratio = round($image->width() / $floor->map_width_in_centimeters, 2);

        $floor->update([
            'image' => $fileName,
            'map_height_in_pixels' => $image->height(),
            'map_width_in_pixels' => $image->width(),
            'map_pixel_to_centimeter_ratio' => $map_pixel_to_centimeter_ratio
        ]);
    }
}
