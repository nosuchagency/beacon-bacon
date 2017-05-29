<?php

namespace App\Traits;

use App\Location;

trait HasLocation
{
    protected static function bootHasLocation()
    {
        self::traitGuard();

        self::deleted(function ($model) {
            if ($model->location_id) {
                $location = Location::find($model->location_id);

                if(!empty($location)) {
                    $location->delete();
                }
            }
        });
    }

    protected static function traitGuard()
    {
        if (auth()->guard('api')->check()) {
            return;
        }

        if (auth()->guest()) {
            throw new \Exception('Permission denied');
        }
    }
}
