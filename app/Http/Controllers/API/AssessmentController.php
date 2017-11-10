<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Assessment;
use App\AssessmentClassfication;

class AssessmentController extends Controller
{
    //

    function index(Request $request){
    	$response = [];
    	$age_group_id = $request->input('age_group');
    	$category_id = $request->input('category');
        $assessments = Assessment::join('asessment_classfication_categories', 'asessment_classfication_categories.id', '=', 'assessments.category_id')
            ->join('assessment_classification_count_view', 'assessment_classification_count_view.id', '=', 'assessments.id')
            ->where('assessments.age_group_id', $age_group_id)
            ->select('assessments.*', 'assessment_classification_count_view.classifications','asessment_classfication_categories.group');
        if ($category_id != 0) {
            $assessments->where('asessment_classfication_categories.id', $category_id);
        }
    	
    	return $assessments->get();
    }

    function all(){
        return Assessment::all();
    }

    function create(Request $request){
    	$age_group_id = $request->input('age_group');
    	$section = $request->input('section');
    	$title = $request->input('title');
    	$assessment = $request->input('assessment');
    	$id = $request->input('id');

    	if ($id) {
    		$_assessment = Assessment::find($id);

    		$_assessment->assessment = $assessment;
    		$_assessment->title = $title;

    	}else{
			$_assessment = new Assessment();

			$_assessment->title = $title;
			$_assessment->age_group_id = $age_group_id;
			$_assessment->category_id = $section;
			$_assessment->assessment = $assessment;
		}

    	$_assessment->save();

    	return $_assessment;
    }

    function get(Request $request){
    	$id = $request->id;
    	$assessment = Assessment::find($id);

    	return $assessment;
    }

    function destroy(Request $request){
        $id = $request->id;

        $counts = \DB::table('assessment_classification_count_view')
                    ->where('id', $id)
                    ->first();

        if ($counts->classifications == 0) {
            Assessment::destroy($id);
        }
    }

    function add_assessment_classification(Request $request){
    	$id = $request->input('classification_id');
    	if (!$id) {
    		$classification = new AssessmentClassfication();

	    	$classification->disease_classification_id = $request->input('category');
	    	$classification->classification = $request->input('classification');
	    	$classification->assessment_id = $request->input('assessment_id');
	    	$classification->parent = $request->input('parent');
            $classification->signs = $request->input('signs');
            $classification->treatments = $request->input('treatments');
    	}else{
    		$classification = AssessmentClassfication::find($id);

    		$classification->disease_classification_id = $request->input('category');
	    	$classification->classification = $request->input('classification');
	    	$classification->parent = $request->input('parent');
            $classification->signs = $request->input('signs');
            $classification->treatments = $request->input('treatments');
    	}
    	
    	$classification->save();

    	return $classification;
    	
    }

    function get_classification(Request $request){
    	$id = $request->id;
    	return AssessmentClassfication::find($id);
    }

    function all_classifications(){
        return AssessmentClassfication::all();
    }
}
