<?php

namespace App\Http\Controllers;

use  App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function add(Request $request){
        $request->validate([
            'f_name' => ['required', 'max:40','string'],
            'l_name'=>['required', 'max:40','string'],
            'description'=>['string','max:255'],
            'email' =>['required','string', 'email', 'max:100'],
        ]);
        Review::create($request->all());
        return response()->json('added successfully');
    }
    public function get(){
        $reviews=Review::all();
        return response()->json($reviews);
    }

}
