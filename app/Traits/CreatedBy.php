<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait CreatedBy
{
    public static function bootCreatedBy()
    {
        static::saving(function ($model) {
            if(!$model->created_by) {
                $created_by = null;
                if (Auth::check()) {
                    $created_by = Auth::user()->id;
                }
                $model->created_by = $created_by;
            }
        });
    }
}