<?php

namespace App;

use App\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use UsedByTeams;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'value'];

    /**
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;
}
