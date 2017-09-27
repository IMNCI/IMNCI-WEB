<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Review;

class ReviewController extends Controller
{
    function index(){
    	$data['reviews'] = Review::all();
    	$data['average'] = Review::avg('rating');
    	return view('dashboard/reviews/index')->with($data);
    }
}
