<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HIVCareParent extends Model
{
    protected $table = "hiv_care_parents";
    protected $fillable = ['parent_name'];

    public function hiv_cares(){
        return $this->hasMany('App\HIVCare', 'id');
    }
}
