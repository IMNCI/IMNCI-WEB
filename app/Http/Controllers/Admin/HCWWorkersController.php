<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\HCWWorkers as Workers;

class HCWWorkersController extends Controller
{
    public function index(){
        $data['workers'] = Workers::all();
        return view('dashboard/hcwworkers/index')->with($data);
    }
}
