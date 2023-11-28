<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Review;
class ReviewController extends Controller
{
    public function addReview(Request $request){
        Review::create($request->all());
        return response()->json('added successfully');
    }
    public function getReviews(){
        $reviews=Review::all();
        return response()->json($reviews);
    } 
    
}
