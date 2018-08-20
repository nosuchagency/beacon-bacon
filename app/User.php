<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Mpociot\Teamwork\Traits\UserHasTeams;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use UserHasTeams, LogsActivity, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_team_id',
        'current_team_id'
    ];

    /**
     * Set which attributes to log.
     *
     * @var array
     */
    protected static $logAttributes = [
        'name',
        'email'
    ];

    /**
     * Shortcut to get if the user is the owner of the current team
     * @return bool
     */
    public function isOwnerOfCurrentTeam()
    {
        $team = $this->currentTeam;
        return $this->isOwnerOfTeam($team);
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
