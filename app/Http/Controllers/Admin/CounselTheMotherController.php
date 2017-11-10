<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\AgeGroup;
use App\CounselTitles;

class CounselTheMotherController extends Controller
{
    function index(){
    	$data = [];

    	$data['cohorts'] = AgeGroup::all();
    	$data['titles']  = CounselTitles::all();
    	return view('dashboard.counsel.index')->with($data);
    }

    function subtitles(){
    	
    }
}
