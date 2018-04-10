<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HIVCare;

class HivCareController extends Controller
{
    //
    function index(){
    	return HIVCare::all();
    }

    function getParents(){
    	$parents = HIVCare::select('parent')->groupBy('parent')->get();

    	$response = [];
    	foreach ($parents as $parent) {
    		$response[] = $parent->parent;
    	}

    	return $response;
    }
}
