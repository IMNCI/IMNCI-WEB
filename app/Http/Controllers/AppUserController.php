<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppUser;

class AppUserController extends Controller
{
    public function getappuser(){
    	return AppUser::all();
    }

    public function addappuser(Request $request){
    	return AppUser::create($request->all());
    }
}
