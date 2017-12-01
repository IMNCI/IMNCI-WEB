<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TreatTitle;
use App\AgeGroup;
use App\TreatAilment;
use App\TreatAilmentTreatment;

class TreatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    function index(){
    	$data['titles'] = TreatTitle::all();
        $data['cohorts'] = AgeGroup::all();
    	return view('dashboard.treat.index')->with($data);
    }

    function ailments(Request $request){
    	$title_id  = $request->id;

    	$title = TreatTitle::find($title_id);
    	$data['title'] = $title;
        $data['ailments'] = TreatAilment::where("treat_titles_id", $title_id)->get();

    	return view('dashboard.treat.ailments')->with($data);
    }

    function treatments(Request $request){
        $ailment_id = $request->id;

        $data['ailment'] = TreatAilment::findOrFail($ailment_id);
        $data['title'] = TreatTitle::findOrFail($data['ailment']->treat_titles_id);
        $data['treatments'] = TreatAilmentTreatment::where("ailment_id", $ailment_id)->get();

        return view('dashboard.treat.treatments')->with($data);
    }
}
