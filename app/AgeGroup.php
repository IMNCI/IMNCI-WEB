<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgeGroup extends Model
{
    protected $fillable = ['age_group'];

    public function ailments(){
    	return $this->hasMany('App\Ailment', 'age_group_id');
    }

    public function treatments(){
    	return $this->hasMany('App\TreatTitle', 'age_group_id');
    }
}
