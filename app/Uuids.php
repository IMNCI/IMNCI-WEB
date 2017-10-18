<?php

namespace App;

use Webpatser\Uuid\Uuid;

trait Uuids
{

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            echo $model->getKetName();die;
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }
}