<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\CounselTitles;

class CounselTheMotherController extends Controller
{
	function index(Request $request){
		return CounselTitles::all();
	}
    function store(Request $request){
    	$post_data = $request->all();

    	if (array_key_exists("is_parent", $post_data)) {
    		$post_data['is_parent'] = ($post_data['is_parent'] == "on") ? true : false;
    	}else{
    		$post_data['is_parent'] = false;
    	}
    	
    	$id = $post_data['title_id'];
    	unset($post_data['title_id']);
    	if ($id == 0) {
    		return CounselTitles::create($post_data);
    	}
    	else{
    		$title = CounselTitles::find($id);

    		$title->title = $post_data['title'];
    		$title->is_parent = $post_data['is_parent'];
    		$title->content = $post_data['content'];
    		$title->age_group_id = $post_data['age_group_id'];

    		$title->save();

    		return $title;
    	}
    }
}
