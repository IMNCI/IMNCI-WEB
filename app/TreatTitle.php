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
}
