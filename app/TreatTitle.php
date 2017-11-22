<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatTitle extends Model
{
    //
    protected $fillable = ['title', 'guide', 'age_group_id'];

    public function age_group(){
    	return $this->belongsTo('App\AgeGroup');
    }

    public function treat_ailments(){
    	return $this->hasMany('App\TreatAilment', 'treat_titles_id');
    }
}
