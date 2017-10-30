<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TreatTitle;
use App\TreatAilment;
use App\TreatAilmentTreatment;

class TreatController extends Controller
{
    //

    function index(){
    	return TreatTitle::all();
    }

    function store(Request $request){
    	$id = $request->input('id');
    	if ($id == 0) {
    		unset($_POST['id']);
    		$treatTitle = TreatTitle::create($request->all());
    	}else{
    		$treatTitle = TreatTitle::find($id);

    		$treatTitle->title = $request->input('title');
    		$treatTitle->guide = $request->input('guide');
            $treatTitle->age_group_id = $request->input('age_group_id');

    		$treatTitle->save();
    	}

    	return $treatTitle;
    }

    function storeAilments(Request $request){
       $id = $request->input('id');
        if ($id == 0) {
            unset($_POST['id']);
            $treatAilment = TreatAilment::create($request->all());
        }else{
            $treatAilment = TreatAilment::find($id);

            $treatAilment->ailment = $request->input('ailment');
            $treatAilment->content = $request->input('content');

            $treatAilment->save();
        }

        return $treatAilment; 
    }

    function storeTreatment(Request $request){
        $id = $request->input('id');
        if ($id == 0) {
            unset($_POST['id']);
            $treatAilmentTreatment = TreatAilmentTreatment::create($request->all());
        }else{
            $treatAilmentTreatment = TreatAilmentTreatment::find($id);

            $treatAilmentTreatment->treatment = $request->input('treatment');
            $treatAilmentTreatment->content = $request->input('content');

            $treatAilmentTreatment->save();
        }

        return $treatAilmentTreatment;
    }
}
