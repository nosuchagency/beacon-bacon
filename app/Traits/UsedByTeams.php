<?php

namespace App\Traits;

/**
 * This file is part of Teamwork
 *
 * @license MIT
 * @package Teamwork
 */

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * Class UsedByTeams
 * @package Mpociot\Teamwork\Traits
 */
trait UsedByTeams
{
    /**
     * Boot the global scope
     */
    protected static function bootUsedByTeams()
    {
        static::addGlobalScope('team', function (Builder $builder) {
            static::teamGuard();

            if (auth()->guard('api')->check()) {
                $builder->where('team_id', auth()->guard('api')->user()->api_team_id);
            }
            else {
                $builder->where('team_id', auth()->user()->currentTeam->getKey());
            }
        });

        static::saving(function (Model $model) {
            static::teamGuard();

            if (!isset($model->team_id)) {
                if (auth()->guard('api')->check()) {
                    $model->team_id = auth()->guard('api')->user()->api_team_id;
                }
                else {
                    $model->team_id = auth()->user()->currentTeam->getKey();
                }
            }
        });
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeAllTeams(Builder $query)
    {
        return $query->withoutGlobalScope('team');
    }

    /**
     * @return mixed
     */
    public function team()
    {
        return $this->belongsTo(Config::get('teamwork.team_model'));
    }

    /**
     * @throws Exception
     */
    protected static function teamGuard()
    {
        if (auth()->guard('api')->check()) {
            return;
        }

        if (auth()->guest() || !auth()->user()->currentTeam) {
            throw new Exception('No authenticated user with selected team present.');
        }
    }
}
