<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function add(Request $request){
       Category::create([
           'name'=>$request->name,
       ]);
        return response()->json('Added Successfully');
    }
    public function edit(Request $request){
        $category=Category::findorfail($request->id);
        $category->update([
            'name'=>$request->name,
        ]);
        return response()->json('Updated Successfully');
    }
    public function delete(Request $request){
        $category=Category::findorfail($request->id);
        $category->products()->delete();
        $category->delete();
        return response()->json('Deleted Successfully');
    }
    public function get(){
        $category=Category::all();
        return response()->json($category);
    }
}
