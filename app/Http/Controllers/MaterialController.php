<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Material;
class MaterialController extends Controller
{
    public function validateMaterialData(Request $request){
        $validator=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
            'address' => 'required|string',
            'product_id' => 'required|exists:product,id',
        ]);
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()],422);
        }
    }
    public function add(Request $request){
        $validation = $this->validateMaterialData($request);
        if ($validation !== null) {
            return $validation;
        }
        $material=Material::create($request->all());
        return response()->json(['success' => true,'data' => $material], 201);
    }
    public function edit(Request $request){
        $validation = $this->validateMaterialData($request);
        if ($validation !== null) {
            return $validation;
        }
        $material=Material::find($request->id);
        if(!$material){return response()->json(['success' => false,'error'=>'material not found'],404);}
        $material->update($request->all());
        return response()->json(['success' => true,'data' => $company], 201);
    }
    public function delete($id){
        $material=Material::find($id);
        if(!$material){return response()->json(['error'=>'material not found'],404);}
        $material->delete();
        return response()->json('Deleted Successfully');
    }
    public function get(){
        $material=Material::all();
        return response()->json($material);
    }
}
