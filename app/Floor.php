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
    protected $fillable = [
        'place_id',
        'name',
        'order',
        'image',
        'map_width_in_centimeters',
        'map_height_in_centimeters',
        'map_width_in_pixels',
        'map_height_in_pixels',
        'map_pixel_to_centimeter_ratio',
        'map_walkable_color',
        'map_background_color'
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
        'name',
        'order',
        'image'
    ];

    /**
     * Get the place.
     *
     */
    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    /**
     * Get locations on this floor.
     *
     */
    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    /**
     * Return full path to image.
     **
     * @return string
     */
    public function getPublicImage()
    {
        return !$this->image ? '' : asset('storage/images/floors/' . $this->id . '/' . $this->image);
    }

    /**
     * Return full virtual path to icon.
     *
     * @return string
     */
    public function getVirtualIconPath()
    {
        return !$this->image ? '' :  url('/floors/' . $this->id . '/image');
    }

    /**
     * Return full physical path to icon.
     *
     * @return string
     */
    public function getPhysicalIconPath()
    {
        return !$this->image ? '' :  storage_path() . '/app/images/floors/' . $this->id . '/' . $this->image;
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
