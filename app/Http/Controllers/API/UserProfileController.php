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
}
