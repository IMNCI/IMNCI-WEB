<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentClassfication extends Model
{
    //
    protected $fillable = ['assessment_id', 'disease_classification_id', 'classification'];
}
