<?php

namespace App\Http\Controllers;

use  App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ReviewController extends Controller
{
    public function add(Request $request){
        $validator=Validator::make($request->all(),[
            'f_name' => 'required|string|max:40',
            'l_name' => 'required|string|max:40',
            'description' => 'required|string|max:255',
            'email' => 'required|email',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false,'errors'=>$validator->errors()],422);
        }
       $review=Review::create($request->all());
        return response()->json(['success' => true,'data' => $review], 201);
    }
    public function get(){
        $reviews=Review::all();
        return response()->json($reviews);
    }

}
