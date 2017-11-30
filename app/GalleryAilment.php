<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryAilment extends Model
{
    //
    protected $fillable = ["ailment"];

    function galleryitems(){
    	return $this->hasMany('App\Gallery');
    }
}
