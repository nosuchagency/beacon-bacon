<?php

namespace App;

use App\Traits\UsedByTeams;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use SoftDeletes, UsedByTeams, HasCreatedBy, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'zipcode', 'city',
        'identifier1', 'identifier2', 'identifier3', 'identifier4', 'identifier5',
        'place_id', 'order', 'beacon_positioning_enabled', 'beacon_proximity_enabled', 'activated'];

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
    protected static $logAttributes = ['name'];

    /**
     * Get floors belonging to this place
     * @return Illuminate\Database\Query\Builder
     */
    public function floors()
    {
      return $this->hasMany('App\Floor');
    }

    /**
     * Get places belonging to this place
     * @return Illuminate\Database\Query\Builder
     */
    public function places()
    {
      return $this->hasMany('App\Place');
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
