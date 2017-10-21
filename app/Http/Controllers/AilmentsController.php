<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ailment;
use App\FollowUpCareAdvice;
use App\FollowUpCareTreatment;

class AilmentsController extends Controller
{
	function index(){
		return Ailment::all();
	}

    function store(Request $request){
        $id = $request->input('ailment_id');
        if ($id != "") {
            $ailment = Ailment::find($id);

            $ailment->ailment = $request->input('ailment');
            $ailment->description = $request->input('description');
            $ailment->age_group_id = $request->input('age_group_id');

            $ailment->save();

            return $ailment;
        }else{
            unset($_POST['id']);
            return Ailment::create($request->all());
        }
    }

    function delete(Request $request){
        $id = $request->id;
        $response = [];

        $advice = FollowUpCareAdvice::where('ailment_id', $id)->count();
        $treatment = FollowUpCareTreatment::where('ailment_id', $id)->count();

        if ($advice == 0 && $treatment == 0) {
            Ailment::destroy($id);
            $response = [
                'status'    =>  true
            ];
        }else{
            $response = [
                'status'    =>  false,
                'message'   =>  "This ailment contains follow up information"
            ];
        }

        return $response;
    }

    function ailmentbyage(Request $request){
    	$age_group = $request->route('age_group_id');
        $ailments = Ailment::leftjoin('age_groups', 'ailments.age_group_id', '=', 'age_groups.id');
        $ailments->leftjoin('follow_up_care_advices', 'follow_up_care_advices.ailment_id', '=', "ailments.id");
        $ailments->leftjoin('follow_up_care_treatments', 'follow_up_care_treatments.ailment_id', '=', "ailments.id");
        if($age_group != 0){
        	$ailments ->where('age_group_id', $age_group)->get();
        }
        $ailments->select('ailments.*', 'age_groups.age_group', 'follow_up_care_advices.advice', 'follow_up_care_treatments.treatment');
        $ailments->orderBy('ailments.id', 'ASC');
    	return $ailments->get();
    }
}
