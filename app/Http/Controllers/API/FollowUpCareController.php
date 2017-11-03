<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FollowUpCareAdvice;
use App\FollowUpCareTreatment;

class FollowUpCareController extends Controller
{
	function getbyailment(Request $request){
		$ailment_id = $request->input('ailment_id');

		$followupAdvice = FollowUpCareAdvice::where('ailment_id', $ailment_id)->first();
		$followUpTreatment = FollowUpCareTreatment::where('ailment_id', $ailment_id)->first();

		$response['advice'] = $followupAdvice;
		$response['treatment'] = $followUpTreatment;

		return response()->json($response);
	}

	function addAdvice(Request $request){
		$advice = FollowUpCareAdvice::where('ailment_id', $request->input('ailment_id'))->first();
		if ($advice) {
			$advice->advice = $request->input('advice');

			$advice->save();

			return $advice;
		}
		return FollowUpCareAdvice::create($request->all());
	}

	function addTreatment(Request $request){
		$ailment_id = $request->input('ailment_id');
		$treatment = FollowUpCareTreatment::where('ailment_id', $ailment_id)->first();
		if ($treatment) {
			$treatment->treatment = $request->input('treatment');

			$treatment->save();

			return $treatment;
		}

		return FollowUpCareTreatment::create($request->all());
	}

	function addAdiveTreatment(Request $request){
		$ailment_id = $request->input('ailment_id');
		$treatment = FollowUpCareTreatment::where('ailment_id', $ailment_id)->first();
		$advice = FollowUpCareAdvice::where('ailment_id', $ailment_id)->first();

		if ($treatment) {
			$treatment->treatment = $request->input('treatment');

			$treatment->save();
		}else{
			$treatment = new \StdClass;

			$treatment->ailment_id = $ailment_id;
			$treatment->treatment = $request->input('treatment');

			$treatment = (array)$treatment;
			FollowUpCareTreatment::create($treatment);
			// $treatment->save();
		}


		if ($advice) {
			$advice->advice = $request->input('advice');

			$advice->save();
		}else{
			$advice = new \StdClass;
			
			$advice->ailment_id = $ailment_id;
			$advice->advice = $request->input('advice');

			$advice = (array) $advice;
			FollowUpCareAdvice::create($advice);
		}
	}

	function get(){
		$advices = FollowUpCareAdvice::all();
		$treatments = FollowUpCareTreatment::all();

		$pre_cleaned_response = [];

		foreach ($advices as $advice) {
			$pre_cleaned_response[$advice->ailment_id]['advice']	=	$advice->advice;
		}

		foreach ($treatments as $treatment) {
			$pre_cleaned_response[$treatment->ailment_id]['treatment']	=	$treatment->treatment;
		}

		$response = [];

		$counter = 1;
		foreach ($pre_cleaned_response as $ailment_id => $value) {
			$response[] = [
				'id'			=>	$counter,
				'ailment_id'	=>	$ailment_id,
				'advice'		=>	isset($value['advice']) ? $value['advice'] : "",
				'treatment'		=>	isset($value['treatment']) ? $value['treatment'] : ""
			];

			$counter++;
		}

		return response()->json($response, 200);
	}
}
