<?php

namespace App;

use App\Traits\BelongsToBeacon;
use App\Traits\UsedByTeams;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes, UsedByTeams, HasCreatedBy, LogsActivity, BelongsToBeacon;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place_id',
        'floor_id',
        'poi_id',
        'block_id',
        'findable_id',
        'type',
        'name',
        'posX',
        'posY',
        'area',
        'rotation',
        'parameter_one',
        'parameter_two',
        'parameter_three',
        'parameter_four',
        'parameter_five',
        'draw_type'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * Set which attributes to log.
     *
     * @var array
     */
    protected static $logAttributes = [
        'poi_id',
        'type',
        'name',
        'posX',
        'posY'
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
     * Get the poi
     */
    public function poi()
    {
        return $this->belongsTo('App\Poi');
    }

    /**
     * Get the findable
     */
    public function findable()
    {
        return $this->belongsTo('App\Findable');
    }

    /**
     * Get the block
     */
    public function block()
    {
        return $this->belongsTo('App\Block');
    }
    
    /**
     * Get the beacon
     */
    public function beacon()
    {
        return $this->hasOne('App\Beacon');
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
