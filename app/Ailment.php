<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ailment extends Model
{
    protected $fillable = ["ailment", "description", "age_group_id"];

    public function age_group(){
    	return $this->belongsTo('App\AgeGroup', 'age_group_id');
    }
}
