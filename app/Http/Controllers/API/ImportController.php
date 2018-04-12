<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\HcwWorkersTmp;

class ImportController extends Controller
{
    public function hcw(Request $request){

    	$results = \Excel::selectSheetsByIndex(0)->load($request->file('file'))->get();

    	foreach($results as $row){
			$worker = new HcwWorkersTmp();

			$worker->hcw_name = $row->hcw_name;
			$worker->county = $row->county;
			$worker->mobile_number = $row->mobile_number;

			$worker->save();
		}

		return HcwWorkersTmp::all();
    }
}
