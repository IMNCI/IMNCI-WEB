<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\CounselTitles;
use App\CounselSubContent;

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

    function delete(Request $request){
        $id = $request->input('title_id');
        $title = CounselTitles::find($id);
        if ($title) {
            if (count($title->subcontent) == 0) {
                return CounselTitles::destroy($id);
            }else{
                abort(405);
            }
        }else{
            abort(404);
        }
    }

    function all_sub_content(){
        return CounselSubContent::all();
    }

    function store_sub_content(Request $request){
        $post_data = $request->all();
        $id = $post_data['sub_content_id'];
        unset($post_data['sub_content_id']);

        if ($id == 0) {
            return CounselSubContent::create($post_data);
        }else{
            $sub_content = CounselSubContent::find($id);

            $sub_content->sub_content_title = $post_data['sub_content_title'];
            $sub_content->content = $post_data['content'];

            $sub_content->save();

            return $sub_content;            
        }       
    }
}
