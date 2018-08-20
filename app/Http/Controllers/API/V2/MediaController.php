<?php

namespace App\Http\Controllers\API\V2;

use App\Floor;
use App\Http\Requests\DateRequest;
use App\Poi;
use Carbon\Carbon;

class MediaController extends Controller
{
    /**
     * Get the specified image resource from storage.
     *
     * @param  Poi $poi
     * @return \Illuminate\Http\Response
     */
    public function icon(Poi $poi)
    {
        $path = storage_path() . '/app/images/pois/' . $poi->id . '/' . $poi->icon;

        if (!file_exists($path)) {
            return response(['message' => 'Resource not found',], 404);
        }

        return response()->file($path);
    }

    /**
     * Get the specified image resource from storage.
     *
     * @param  Floor $floor
     * @return \Illuminate\Http\Response
     */
    public function image(Floor $floor)
    {
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
     * @param  Poi $poi
     * @return \Illuminate\Http\Response
     */
    public function iconUpdated(DateRequest $request, Poi $poi)
    {
        if ($request->has('date')) {
            $inputDate = Carbon::parse($request->input('date'));
            $imageDate = Carbon::parse($poi->updated_at);

            $hasBeenUpdated = $imageDate->greaterThan($inputDate);
        } else {
            $hasBeenUpdated = true;
        }

        return response()->json(['update' => $hasBeenUpdated], 200);
    }

    /**
     * Get the specified image resource from storage.
     *
     * @param   $request
     * @param  Floor $floor
     * @return \Illuminate\Http\Response
     */
    public function imageUpdated(DateRequest $request, Floor $floor)
    {
        if ($request->has('date')) {
            $inputDate = Carbon::parse($request->input('date'));
            $imageDate = Carbon::parse($floor->updated_at);

            $hasBeenUpdated = $imageDate->greaterThan($inputDate);
        } else {
            $hasBeenUpdated = true;
        }

        return response()->json(['update' => $hasBeenUpdated], 200);
    }
}