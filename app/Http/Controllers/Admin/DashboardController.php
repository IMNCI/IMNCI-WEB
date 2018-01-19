<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppUser;
use App\UserProfile;
use App\Review;

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
        $profiles = UserProfile::count();

        $month = date('Y-m');
        $appusers_this_month = \DB::select(\DB::raw('SELECT count(id)  as users FROM app_users
        WHERE DATE_FORMAT(created_at,"%Y-%m") = "'.$month.'"
        GROUP BY DATE_FORMAT(created_at,"%Y-%m");'));
    	return view('dashboard/dashboard/index')->with(['appusers'=>$appusers, 'month_users'   =>  $appusers_this_month[0]->users, 'profiles'=>$profiles]);
    }
}
