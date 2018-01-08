<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\AgeGroup;
use App\CounselTitles;
use App\CounselSubContent;

class CounselTheMotherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function index(){
    	$data = [];

    	$data['cohorts'] = AgeGroup::all();
    	$data['titles']  = CounselTitles::all();
    	return view('dashboard.counsel.index')->with($data);
    }

    function subtitles(Request $request){
    	try{
	    	$title = CounselTitles::findOrFail($request->title_id);
	    	$data = [];

	    	$data['title'] = $title;
            $data['cohort'] = $title->cohort;
	    	return view('dashboard.counsel.subtitles')->with($data);
	    }catch(Exception $ex){
	    	echo "There is another thing here";
	    }
    	
    }
}
