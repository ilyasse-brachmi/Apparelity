<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Models\Material;
class MaterialController extends Controller
{
    public function add(Request $request){
        $request->validate([
            'name' => ['required','string', 'max:40'],
            'origin'=>['required','string','max:255'],
            'supplier'=>['required','string','max:255'],
            'address' => ['required','string','max:255'],
            'product_id' => 'required',
        ]);
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
        $request->validate([
            'name' => ['required','string', 'max:40'],
            'origin'=>['required','string','max:255'],
            'supplier'=>['required','string','max:255'],
            'address' => ['required','string','max:255'],
            'product_id' => 'required',
        ]);
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
        $materials=Material::all();
        foreach($materials as $key=>$material){
            $data[$key]=(new \App\Models\Material)->convertToArray($material);
        }
        return response()->json($data);
    }
}
