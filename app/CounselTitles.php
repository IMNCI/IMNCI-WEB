<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CounselTitles extends Model
{
    protected $fillable = ["title", "is_parent", "content", "age_group_id"];

    public function cohort(){
    	return $this->belongsTo('App\AgeGroup', 'age_group_id');
    }

    public function subcontent(){
    	return $this->hasMany('App\CounselSubContent');
    }
}
