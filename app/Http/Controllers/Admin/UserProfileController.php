<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\UserProfile;

class UserProfileController extends Controller
{
    function index(){
    	$data = [];
    	$data['profiles'] = UserProfile::all();
    	return view('dashboard.user_profile.index', $data);
    }
}
