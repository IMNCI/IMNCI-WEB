<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HIVCare extends Model
{
    //
    protected $fillable = ["title", "thumbnail", "image_path", "parent_id"];

    public function parent(){
        return $this->belongsTo('App\HIVCareParent', 'parent_id');
    }
}
