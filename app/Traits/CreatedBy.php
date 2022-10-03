<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait CreatedBy
{
    public static function bootCreatedBy()
    {
        static::saving(function ($model) {
            if ( !Auth::check()) {
                return;
            }
            $model->created_by = Auth::user()->id;
        });
    }
}