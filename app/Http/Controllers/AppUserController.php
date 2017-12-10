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
    	$display_no = $request->input('display_no');

    	$appuser = AppUser::where('display_no', $display_no)->first();
    	if ($appuser) {
    		$appuser->phone_id = $request->input('phone_id');
            $appuser->save();
    	}else{
    		$appuser = AppUser::create($request->all());
    	}
    	return $appuser;
    }
}
