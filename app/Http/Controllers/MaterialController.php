<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Models\Material;
class MaterialController extends Controller
{
    public function add(MaterialRequest $request){

        Material::create([
            'name'=>$request->name,
            'origin'=>$request->origin,
            'supplier'=>$request->supplier,
            'address'=>$request->address,
            'product_id'=>$request->product_id
        ]);
        return response()->json('Added Successfully');

    }
    public function edit(MaterialRequest $request){
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
    public function delete(MaterialRequest $request){
        $material=Material::findorfail($request->id);
        $material->delete();
        return response()->json('Deleted Successfully');
    }
    public function get(){
        $material=Material::all();
        return response()->json($material);
    }
}
