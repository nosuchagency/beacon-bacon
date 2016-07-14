<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Teamwork\Traits\UsedByTeams;

class ApiKey extends Model
{
    use UsedByTeams;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'api_token'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_used'];

    /**
     * Get the user.
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
