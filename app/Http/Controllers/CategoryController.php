<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function add(Request $request){
        $validator=Validator::make($request->all(),[
            'name' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
       Category::create([
           'name'=>$request->name,
       ]);
        return response()->json('Added Successfully');
    }
    public function edit(Request $request){
        $validator=Validator::make($request->all(),[
            'name' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $category=Category::find($request->id);
        if(!$category){return response()->json(['error'=>'Category not found'],404);}
        $category->update($request->all());
        return response()->json('Updated Successfully');
    }
    public function delete( $id){
            $category=Category::find($id);
            if(!$category){return response()->json(['error'=>'Category not found'],404);}
            $category->products()->delete();
            $category->delete();
            return response()->json('Deleted Successfully');
            
    }
    public function get(){
        $category=Category::all();
        return response()->json($category);
    }
}
