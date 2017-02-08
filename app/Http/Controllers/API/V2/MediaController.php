<?php

namespace App\Http\Controllers\API\V2;

use App\Floor;
use App\Poi;
use Image;
use File;

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
        $poi = Poi::find($id);

        if(!$poi) {
            return response(['message' => 'Resource not found',], 404);
        }

        $path = storage_path() . '/app/images/pois/' . $poi->id . '/' . $poi->icon;

        if(!File::exists($path)) {
            return response(['message' => 'Resource not found',], 404);
        }

        return Image::make($path)->response();
    }

    /**
     * Get the specified image resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function image($id)
    {
        $floor = Floor::find($id);

        if(!$floor) {
            return response(['message' => 'Resource not found',], 404);
        }

        $path = storage_path() . '/app/images/floors/' . $floor->id . '/' . $floor->image;

        if(!File::exists($path)) {
            return response(['message' => 'Resource not found',], 404);
        }

        return Image::make($path)->response();
    }
}