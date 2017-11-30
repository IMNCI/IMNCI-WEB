<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\GalleryAilment;

class GalleryAilmentController extends Controller
{
    //
    function index(){
    	$data = [];
    	$data['ailments'] = GalleryAilment::all();
    	return view('dashboard.gallery.ailments')->with($data);
    }

    function store(Request $request){
    	GalleryAilment::create($request->all());
    	return redirect('/gallery-ailments');
    }
}
