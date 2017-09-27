<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;

class ReviewController extends Controller
{
    public function index(){
    	return Review::all();
    }

    public function show(Review $review){
    	return $review;
    }

    public function store(Request $request){
    	$review = Review::create($request->all());

    	return response()->json($review, 200);
    }
}
