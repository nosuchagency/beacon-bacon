<?php

namespace App;

use App\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    use UsedByTeams, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value'
    ];

    /**
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Set which attributes to log.
     *
     * @var array
     */
    protected static $logAttributes = [
        'key',
        'value'
    ];
}
