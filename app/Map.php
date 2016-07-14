<?php

namespace App;

use App\Traits\UsedByTeams;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Map extends Model
{
    use SoftDeletes, UsedByTeams, HasCreatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['place_id', 'name', 'order', 'image'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];

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
     * Get locations on this map.
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    /**
     * Return full path to image.
     *
     * @param string $value
     *
     * @return string
     */
    public function getImageAttribute($value)
    {
        return !$value ?: asset('uploads/maps/'.$this->id.'/'.$value);
    }
}
