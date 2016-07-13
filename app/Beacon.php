<?php

namespace App;

use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Mpociot\Teamwork\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beacon extends Model
{
    use SoftDeletes, UsedByTeams, HasCreatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place_id', 'map_id', 'name', 'description', 'posX', 'posY',
        'beacon_uid', 'proximity_uuid', 'major', 'minor'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the place
     * @return Illuminate\Database\Query\Builder
     */
    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    /**
     * Get the map
     * @return Illuminate\Database\Query\Builder
     */
    public function map()
    {
        return $this->belongsTo('App\Map');
    }
}