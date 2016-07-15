<?php

namespace App;

use App\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use UsedByTeams;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['place_id', 'category_id', 'title', 'order'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $hidden = ['team_id', 'place_id', 'category_id'];

    /**
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

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
     * Get the category.
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
