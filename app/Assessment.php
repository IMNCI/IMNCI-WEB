<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    //
    protected $fillable = ['age_group_id', 'category_id', 'title', 'assessment'];

    public function classifications(){
    	return $this->hasMany('App\AssessmentClassfication', 'id');
    }

    public function age_group(){
    	return $this->belongsTo('App\AgeGroup', 'age_group_id');
    }
}
