<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatAilment extends Model
{
    //

    protected $fillable = ["ailment", "content", "treat_titles_id"];

    public function treat_title(){
    	return $this->belongsTo('App\TreatTitle', 'id');
    }

    public function treatments(){
    	return $this->hasMany('App\TreatAilmentTreatment', 'ailment_id');
    }
}
