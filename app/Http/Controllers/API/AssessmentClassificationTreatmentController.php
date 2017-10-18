<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssessmentClassificationTreatment;

class AssessmentClassificationTreatmentController extends Controller
{
	function index(){
		return AssessmentClassificationTreatment::all();
	}

	function store(Request $request){
		$treatment = AssessmentClassificationTreatment::where('classification_id', $request->input('classification_id'))->first();
		if ($treatment) {
			$treatment->treatment = $request->input('treatment');

			$treatment->save();

			return $treatment;
		}
		return AssessmentClassificationTreatment::create($request->all());
	}

	function get_by_classification(Request $request){
    	$classification_id = $request->classification_id;

    	return AssessmentClassificationTreatment::where('classification_id', $classification_id)->get();
    }
}
