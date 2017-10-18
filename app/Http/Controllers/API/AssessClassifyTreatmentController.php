<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Assessment;

class AssessClassifyTreatmentController extends Controller
{
	function get(Request $request){
		$response = [];
		$age_group = $request->input('age_group');
		$section = $request->input('section');

		$assessment = Assessment::where('age_group_id', $age_group)
    								->where('category_id', $section)
    								->first();

    	$view_data = [
    		'assessment'	=>	$assessment
    	];
		
		$response['view'] = (string) \View::make('api/assess_classify_treatment', $view_data);

		return response()->json($response);
	}
}
