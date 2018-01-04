<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Review;

class ReviewController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
    	$data['reviews'] = Review::orderBy('created_at', 'DESC')->get();
    	$data['average'] = Review::avg('rating');
    	return view('dashboard/reviews/index')->with($data);
    }
}
