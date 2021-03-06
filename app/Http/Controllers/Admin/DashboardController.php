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
        $years = AppUser::distinct()
            ->orderBy('year', 'DESC')
            ->get([
                \DB::raw('YEAR(opened_at) AS `year`')
            ]);

        $profiles = UserProfile::count();

        $month = date('Y-m');

        $appusers_this_month = \DB::select(\DB::raw('SELECT count(id)  as users FROM app_users
        WHERE DATE_FORMAT(created_at,"%Y-%m") = "'.$month.'"
        GROUP BY DATE_FORMAT(created_at,"%Y-%m");'));
        
        $month_users =(isset($appusers_this_month[0]->users)) ? $appusers_this_month[0]->users : 0;
        
    	return view('dashboard/dashboard/index')->with(['years' => $years, 'appusers'=>$appusers, 'month_users'   =>  $month_users, 'profiles'=>$profiles]);
    }
}
