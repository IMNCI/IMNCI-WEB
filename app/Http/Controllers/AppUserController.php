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
            $appuser->opened_at = $request->input('opened_at');
            $appuser->brand = $request->input('brand');
            $appuser->model = $request->input('model');
            $appuser->device = $request->input('device');
            $appuser->android_version = $request->input('android_version');
            $appuser->display_no = $request->input('display_no');
            $appuser->android_sdk = $request->input('android_sdk');
            $appuser->android_release = $request->input('android_release');
            $appuser->device_model = $request->input('device_model');
            $appuser->save();
    	}else{
    		$appuser = AppUser::create($request->all());
    	}
    	return $appuser;
    }
}
