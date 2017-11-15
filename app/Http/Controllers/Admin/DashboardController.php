<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppUser;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(){
        $appusers = AppUser::orderBy('updated_at', 'DESC')->get();
    	return view('dashboard/dashboard/index')->with(['appusers'=>$appusers]);
    }
}
