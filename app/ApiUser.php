<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class ApiUser extends User
{
    protected $table = 'users';

    /**
     * Boot the global scope
     */
    protected static function boot()
    {
        static::addGlobalScope('api_token', function (Builder $builder) {
            $builder->join('api_keys', 'users.id', '=', 'api_keys.user_id')->select(['users.*', 'api_keys.team_id as api_team_id']);
        });
    }
}
