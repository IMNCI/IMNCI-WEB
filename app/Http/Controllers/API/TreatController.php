<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TreatTitle;

class TreatController extends Controller
{
    //
    function store(Request $request){
    	$id = $request->input('id');
    	if ($id == 0) {
    		unset($_POST['id']);
    		$treatTitle = TreatTitle::create($request->all());
    	}else{
    		$treatTitle = TreatTitle::find($id);

    		$treatTitle->title = $request->input('title');
    		$treatTitle->guide = $request->input('guide');

    		$treatTitle->save();
    	}

    	return $treatTitle;
    }
}
