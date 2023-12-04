<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use  App\Models\Review;
class ReviewController extends Controller
{
    public function add(ReviewRequest $request){
        Review::create([
            'f_name'=>$request->f_name,
            'l_name'=>$request->l_name,
            'email'=>$request->email,
            'description'=>$request->description,
            ]);
        return response()->json('added successfully');
    }
    public function get(){
        $reviews=Review::all();
        return response()->json($reviews);
    }
}
