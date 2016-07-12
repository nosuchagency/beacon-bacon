<?php

namespace App;

use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Mpociot\Teamwork\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes, UsedByTeams, HasCreatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['place_id', 'map_id', 'category_id', 'name', 'posX', 'posY'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the place
     * @return Illuminate\Database\Query\Builder
     */
    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    /**
     * Get the map
     * @return Illuminate\Database\Query\Builder
     */
    public function map()
    {
        return $this->belongsTo('App\Map');
    }

    /**
     * Get the category
     * @return Illuminate\Database\Query\Builder
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
