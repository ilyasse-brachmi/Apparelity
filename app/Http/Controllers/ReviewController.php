<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use  App\Models\Review;
class ReviewController extends Controller
{
    public function add(ReviewRequest $request){
        Review::create($request->all());
        return response()->json('added successfully');
    }
    public function get(){
        $reviews=Review::all();
        return response()->json($reviews);
    }

}
