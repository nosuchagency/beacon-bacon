<?php

namespace App;

use App\Traits\HasLocation;
use App\Traits\UsedByTeams;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beacon extends Model
{
    use SoftDeletes, UsedByTeams, HasCreatedBy, LogsActivity, HasLocation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place_id',
        'floor_id',
        'location_id',
        'name',
        'description',
        'posX',
        'posY',
        'beacon_uid',
        'proximity_uuid',
        'major',
        'minor'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];

    /**
     * Set which attributes to log.
     *
     * @var array
     */
    protected static $logAttributes = [
        'name',
        'description',
        'posX',
        'posY',
        'beacon_uid',
        'proximity_uuid',
        'major',
        'minor'
    ];

    /**
     * Get the place
     */
    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    /**
     * Get the floor
     */
    public function floor()
    {
        return $this->belongsTo('App\Floor');
    }

    /**
     * Get the location
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    /**
     * Set the log name when using API.
     *
     * @param string $eventName
     *
     * @return string
     */
    public function getLogNameToUse($eventName = '')
    {
        return auth()->guard('api')->check() ? 'api_log' : config('laravel-activitylog.default_log_name');
    }
}