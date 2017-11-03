<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentClassfication extends Model
{
    //
    protected $fillable = ['assessment_id', 'disease_classification_id', 'classification', 'signs', 'treatments'];

    public function assessment(){
    	return $this->belongsTo('App\Assessment', 'assessment_id');
    }
}
