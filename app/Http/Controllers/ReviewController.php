<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Review;
use App\Jobs\SendIssueEmail;

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
        dispatch(new SendIssueEmail($review));
    	return response()->json($review, 200);
    }

    public function update(Request $request){
        $id = $request->input('id');
        $action = $request->input('action');

        $review = Review::findOrFail($id);

        if ($review) {
            $review->status = ($action == "solve") ? "solved" : "archived";

            $review->save();

            return $review;
        }
    }
}
