<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssessmentClassificationSign;

class AssessmentClassificationSignController extends Controller
{
	function index(){
		return AssessmentClassificationSign::all();
	}
	function store(Request $request){
		$sign = AssessmentClassificationSign::where('classification_id', $request->input('classification_id'))->first();
		if ($sign) {
			$sign->sign = $request->input('sign');
			$sign->save();

			return $sign;
		}
		return AssessmentClassificationSign::create($request->all());
	}

    function get_by_classification(Request $request){
    	$classification_id = $request->classification_id;

    	return AssessmentClassificationSign::where('classification_id', $classification_id)->get();
    }
}
