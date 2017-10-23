<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TreatTitle;

class TreatController extends Controller
{
    //
    function index(){
    	$data['titles'] = TreatTitle::all();
    	return view('dashboard.treat.index')->with($data);
    }

    function treatment(Request $request){
    	$title_id  = $request->id;

    	$title = TreatTitle::find($title_id);
    	$data['title'] = $title;

    	return view('dashboard.treat.treatment')->with($data);
    }
}
