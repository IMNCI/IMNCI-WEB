<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatTitle extends Model
{
    //
    protected $fillable = ['title', 'guide'];

    public function age_group(){
    	return $this->belongsTo('App\AgeGroup');
    }
}
