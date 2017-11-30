<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    //
    protected $fillable = ["title", "description", "gallery_ailments_id", "gallery_items_id", "thumbnail", "link", "size", "mime", "type"];

    function ailment(){
    	return $this->belongsTo('App\GalleryAilment', "gallery_ailments_id");
    }

    function category(){
    	return $this->belongsTo('App\GalleryItem', 'gallery_items_id');
    }
}
