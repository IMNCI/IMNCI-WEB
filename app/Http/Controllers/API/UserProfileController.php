<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserProfile;

class UserProfileController extends Controller
{
    function store(Request $request){
    	$profile = UserProfile::create($request->all());

    	return $profile;
    }

    function genderStatistics(){
    	$gender = UserProfile::select('gender', \DB::raw('count(*) as total'))->groupBy('gender')->get();

        return $gender;
    }

    function cohortStatistics(){
    	$cohort = UserProfile::select('age_group', \DB::raw('count(*) as total'))->groupBy('age_group')->get();

    	return $cohort;
    }

    function sectorStatistics(){
    	$sectors = UserProfile::select('sector', \DB::raw('count(*) as total'))->groupBy('sector')->get();

    	return $sectors;
    }
}
