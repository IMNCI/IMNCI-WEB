<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\AssessmentClassfication;
use App\AssessmentClassificationTreatment;
use App\AssessmentClassificationSign;

class ClassificationController extends Controller
{
    function remove(Request $request){
    	$classification_id = $request->classification_id;

    	$treatment = AssessmentClassificationTreatment::where('classification_id', $classification_id)->first();
    	$sign = AssessmentClassificationSign::where('classification_id', $classification_id)->first();

    	// $classification = AssessmentClassfication::where('id', $classification_id)->firstOrFail();
    	if (count($treatment)) {
    		$treatment->delete();
    	}
    	if ($sign) {
    		$sign->delete();
    	}
    	AssessmentClassfication::destroy($classification_id);

    	return ['status'	=>	true, 'message'=>"succesfully deleted"];
    }
}
