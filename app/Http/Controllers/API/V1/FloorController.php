<?php

namespace App\Http\Controllers\API\V1;

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
        return $this->filteredAndOrdered($request, new Floor())->paginate($this->pageSize);
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
            'map_height_in_centimeters' => 'required|numeric',
            'map_width_in_centimeters' => 'required|numeric',
            'image' => 'required|image',
        ]);

        $floor = Floor::create($request->except('image'));

        $this->uploadFloor($floor, $request);

        return response($floor, 201);
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
        $place = Floor::findOrFail($id);

        return $this->attachResources($request, $place);
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
            'map_height_in_centimeters' => 'required|numeric',
            'map_width_in_centimeters' => 'required|numeric',
            'image' => 'required|image',
        ]);

        $floor = Floor::findOrFail($id);

        $floor->update($request->except('image'));

        $this->uploadFloor($floor, $request);

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
        Floor::findOrFail($id)->delete();

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
        if (!$request->hasFile('image')) {
            return;
        }

        $destinationPath = public_path('uploads/floors/' . $floor->id);
        $fileName = $request->file('image')->getClientOriginalName();

        if ($floor->image && is_file($destinationPath . '/' . $floor->image)) {
            unlink($destinationPath . '/' . $floor->image);
        }

        $request->file('image')->move($destinationPath, $fileName);

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
