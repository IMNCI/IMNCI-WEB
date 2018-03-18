<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    public function hcw(Request $request){
        echo "<pre>";print_r($request->file('hcwsheet'));
       echo $request->file('hcwsheet');
    }
}
