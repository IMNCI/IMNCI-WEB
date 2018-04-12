<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\HCWWorkers as Workers;
use App\HCWWorkersTmp;
use App\County;

class HCWWorkersController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $data['workers'] = Workers::all();
        return view('dashboard/hcwworkers/index')->with($data);
    }

    public function uploadPage(){
    	$temp = HCWWorkersTmp::count();
    	$data['temp_count'] = $temp;
        $data['counties'] = County::pluck('county', 'county');
    	return view('dashboard.hcwworkers.upload')->with($data);
    }
}
