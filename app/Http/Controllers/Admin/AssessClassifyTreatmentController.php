<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\AgeGroup;
use App\AsessmentClassficationCategory;
use App\Assessment;
use App\DiseaseClassification;
use App\AssessmentClassfication;
use App\AssessmentClassificationSign;
use App\AssessmentClassificationTreatment;

class AssessClassifyTreatmentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(){
    	$data = [];
    	$data['age_groups'] = AgeGroup::all();
    	$data['sections'] = AsessmentClassficationCategory::all();
    	return view('dashboard/assess_classify/index')->with($data);
    }

    function classification(Request $request){
        $id = $request->id;
        $data['assessment'] = Assessment::find($id);
        $data['categories'] = DiseaseClassification::all();
        $data['classifications'] = AssessmentClassfication::join('disease_classifications', 'assessment_classfications.disease_classification_id', '=', 'disease_classifications.id')->where('assessment_id', $id)->select('assessment_classfications.*', 'disease_classifications.color')->get();
        $data['parents'] = AssessmentClassfication::where('assessment_id', $id)->select('parent')->groupBy('parent')->get();
        $data['signs'] = AssessmentClassificationSign::where('classification_id', $id)->first();
        $data['treatment'] = AssessmentClassificationTreatment::where('classification_id', $id)->first();

        return view('dashboard/assess_classify/classification')->with($data);
    }

    function signsandtreatments(Request $request){
        $id = $request->id;
        $data = [];
        $data['classification'] = AssessmentClassfication::find($id);
        $data['signs'] = AssessmentClassificationSign::where('classification_id', $id)->first();
        $data['treatment'] = AssessmentClassificationTreatment::where('classification_id', $id)->first();

        return view('dashboard/assess_classify/signs_treatments')->with($data);
    }
}
