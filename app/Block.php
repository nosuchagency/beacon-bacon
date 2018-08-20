<?php

namespace App;

use App\Traits\UsedByTeams;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use SoftDeletes, UsedByTeams, HasCreatedBy, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
        'height',
        'width'
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
        'image'
    ];

    /**
     * Return full virtual path to icon.
     *
     * @return string
     */
    public function getVirtualIconPath()
    {
        return !$this->image ? '' :  url('/blocks/' . $this->id . '/image');
    }

    /**
     * Return full physical path to icon.
     *
     * @return string
     */
    public function getPhysicalIconPath()
    {
        return !$this->image ? '' :  storage_path() . '/app/images/blocks/' . $this->id . '/' . $this->image;
    }


    /**
     * Get locations belonging to this poi
     */
    public function locations()
    {
      return $this->hasMany('App\Location');
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
