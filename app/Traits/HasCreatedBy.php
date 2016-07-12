<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasCreatedBy
{
    /**
     * Boot the global scope
     */
    protected static function bootHasCreatedBy()
    {
        static::saving(function (Model $model) {
            static::userGuard();

            if (!isset($model->created_by)) {
                $model->created_by = auth()->user()->getKey();
            }
        });
    }

    /**
     * Get the creator
     * @return Illuminate\Database\Query\Builder
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @throws Exception
     */
    protected static function userGuard()
    {
        if (auth()->guest()) {
            throw new Exception('No authenticated user.');
        }
    }
}