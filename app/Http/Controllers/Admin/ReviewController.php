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
    	$data['reviews'] = Review::orderBy('created_at', 'ASC')->get();
    	$data['issues'] = $this->createReviewsListing();
    	$data['average'] = Review::avg('rating');
    	return view('dashboard/reviews/index')->with($data);
    }

    function createReviewsListing(){
    	$sections = ['pending', 'solved', 'archived'];

    	$review_listing = [];

    	foreach ($sections as $section) {
    		$review_listing[$section] = [];
    	}

    	$issues = Review::orderBy('created_at', 'ASC')->get();

    	foreach ($issues as $issue) {
    		$review_listing[$issue->status][] = $issue;
    	}

    	return $review_listing;
    }
}
