<?php

namespace App;

use Mpociot\Teamwork\Traits\UserHasTeams;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use UserHasTeams;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
}
