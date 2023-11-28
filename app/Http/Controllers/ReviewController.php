<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Review;
class ReviewController extends Controller
{
    public function add(Request $request){
        Review::create($request->all());
        return response()->json('added successfully');
    }
    public function get(){
        $reviews=Review::all();
        return response()->json($reviews);
    } 
    
}
