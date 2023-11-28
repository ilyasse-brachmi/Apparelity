<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function adding(Request $request){

        Material::create([
            'name'=>$request->name,
            'origin'=>$request->origin,
            'supplier'=>$request->supplier,
            'address'=>$request->address,
            'product_id'=>$request->product_id
        ]);
        return response()->json('Added Successfully');

    }
    public function edit(Request $request){
        $category=Material::findorfail($request->id);
        $category->update([
            'name'=>$request->name,
            'origin'=>$request->origin,
            'supplier'=>$request->supplier,
            'address'=>$request->address,
            'product_id'=>$request->product_id
        ]);
        return response()->json('Updated Successfully');
    }
    public function delete(Request $request){
        $material=Material::findorfail($request->id);
        $material->delete();
        return response()->json('Deleted Successfully');
    }
    public function getData(){
        $material=Material::all();
        return response()->json($material);
    }
}
