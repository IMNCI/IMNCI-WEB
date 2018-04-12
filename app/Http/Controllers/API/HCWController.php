<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\HcwWorkersTmp;

class HCWController extends Controller
{
    function allTemp(){
    	return HcwWorkersTmp::all();
    }

    function update(Request $request){
    	echo ""; print_r($request->input());die;
    }
}
