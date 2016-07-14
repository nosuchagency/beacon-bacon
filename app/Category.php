<?php

namespace App;

use App\Traits\UsedByTeams;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, UsedByTeams, HasCreatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'internal_name', 'icon'];

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
     * Return full path to icon.
     *
     * @param string $value
     *
     * @return string
     */
    public function getIconAttribute($value)
    {
        !$value ?: asset('uploads/categories/'.$this->id.'/'.$value);
    }
}
