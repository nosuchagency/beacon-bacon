<?php

namespace App\Http\Controllers\API\V2;

use App\Floor;
use App\Poi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Get the specified image resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function icon($id)
    {
        $poi = Poi::findOrFail($id);

        $path = storage_path() . '/app/images/pois/' . $poi->id . '/' . $poi->icon;

        if (!file_exists($path)) {
            return response(['message' => 'Resource not found',], 404);
        }

        return response()->file($path);
    }

    /**
     * Get the specified image resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function image($id)
    {
        $floor = Floor::findOrFail($id);

        $path = storage_path() . '/app/images/floors/' . $floor->id . '/' . $floor->image;

        if (!file_exists($path)) {
            return response(['message' => 'Resource not found',], 404);
        }

        return response()->file($path);
    }

    /**
     * Get the specified image resource from storage.
     *
     * @param   $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updated(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'nullable|date',
        ]);

        $date = $request->get('date');

        if (empty($date)) {
            $hasBeenUpdated = true;
        } else {
            $floor = Floor::findOrFail($id);

            $inputDate = Carbon::parse($date);
            $imageDate = Carbon::parse($floor->updated_at);

            $hasBeenUpdated = $imageDate->greaterThan($inputDate);
        }

        return response()->json(['update' => $hasBeenUpdated], 200);
    }
}