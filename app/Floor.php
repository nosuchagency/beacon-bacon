<?php

namespace App;

use App\Traits\UsedByTeams;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Floor extends Model
{
    use SoftDeletes, UsedByTeams, HasCreatedBy, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['place_id', 'name', 'order', 'image', 'map_width_in_centimeters', 'map_height_in_centimeters', 'map_width_in_pixels', 'map_height_in_pixels', 'map_pixel_to_centimeter_ratio', 'map_walkable_color'];

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
    protected static $logAttributes = ['name', 'order', 'image'];

    /**
     * Get the place.
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    /**
     * Get locations on this floor.
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    /**
     * Return full path to image.
     *
     * @param string $value
     *
     * @return string
     */
    public function getImageAttribute($value)
    {
        return !$value ? '' : asset('uploads/floors/'.$this->id.'/'.$value);
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
