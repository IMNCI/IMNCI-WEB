<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiseaseClassification extends Model
{
    //
    protected $fillable = ['classification', 'description', 'color'];
}
