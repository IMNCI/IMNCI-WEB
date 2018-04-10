<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HIVCare extends Model
{
    //
    protected $fillable = ["title", "parent", "content"];

    public function parent(){
        return $this->belongsTo('App\HIVCareParent', 'parent_id');
    }
}
