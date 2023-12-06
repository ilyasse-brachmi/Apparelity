<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
class CategoryController extends Controller
{
    public function add(CategoryRequest $request){
       Category::create([
           'name'=>$request->name,
       ]);
        return response()->json('Added Successfully');
    }
    public function edit(CategoryRequest $request){
        $category=Category::findorfail($request->id);
        $category->update([
            'name'=>$request->name,
        ]);
        return response()->json('Updated Successfully');
    }
    public function delete(CategoryRequest $request){
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
