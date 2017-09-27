<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessClassifyTreatmentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(){
    	return view('dashboard/assess_classify/index');
    }
}
