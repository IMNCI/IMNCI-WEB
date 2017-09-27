<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ailment;

class AilmentsController extends Controller
{
	function index(){
		return Ailment::all();
	}

    function store(Request $request){
    	return Ailment::create($request->all());
    }

    function ailmentbyage(Request $request){
    	$age_group = $request->route('age_group_id');

    	$ailments = Ailment::where('age_group_id', $age_group)->get();

    	return $ailments;
    }
}
