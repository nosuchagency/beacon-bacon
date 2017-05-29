<?php

namespace App\Traits;

use App\Beacon;

trait BelongsToBeacon
{

    protected static function bootBelongsToBeacon()
    {
        self::traitGuard();

        self::deleted(function ($model) {
            if ($model->type == 'beacon' && $model->id) {
                $beacon = Beacon::where('location_id', '=', $model->id)->first();

                if(!empty($beacon)) {
                    $beacon->place_id = 0;
                    $beacon->floor_id = 0;
                    $beacon->location_id = 0;
                    $beacon->save();
                }
            }
        });
    }

    protected static function traitGuard()
    {
        if (auth()->guest()) {
            throw new \Exception('Permission denied');
        }
    }
}
