<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
class CategoryController extends Controller
{
    public function add(Request $request){
        $request->validate([
            'name' => ['required', 'max:40']
        ]);
       Category::create([
           'name'=>$request->name,
       ]);
        return response()->json('Added Successfully');
    }
    public function edit(Request $request){
        $request->validate([
            'name' => ['required', 'max:40']
        ]);
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
