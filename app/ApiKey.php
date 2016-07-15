<?php

namespace App;

use App\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ApiKey extends Model
{
    use UsedByTeams, LogsActivity;

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
     * Set which attributes to log.
     *
     * @var array
     */
    protected static $logAttributes = ['name', 'api_token'];

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
