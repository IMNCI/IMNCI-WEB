<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AgeGroup;
use App\Ailment;

class AilmentsController extends Controller
{
    //
    function index(){
    	$data = [];
    	$data['cohorts'] = AgeGroup::all();
    	return view('dashboard/ailments/index')->with($data);
    }
}
