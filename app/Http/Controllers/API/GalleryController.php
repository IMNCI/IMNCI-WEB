<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Gallery;

class GalleryController extends Controller
{
    //

    function index(){}

    function getGalleryDetailsView(Request $request){
    	$gallery = Gallery::findOrFail($request->id);

    	return \View::make('dashboard.gallery.gallery_details')->with(["gallery"=>$gallery]);
    }

    function remove(Request $request){
    	$gallery = Gallery::findOrFail($request->id);

    	if(\Storage::exists($gallery->link)){
    		$file = $gallery->link;

    		Gallery::destroy($request->id);
    		\Storage::delete($file);

    	}else{

	    	abort(404);
	    }
    }
}
