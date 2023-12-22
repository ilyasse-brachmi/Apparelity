<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Material;
use App\Models\Product;
class MaterialController extends Controller
{      
    // public function add(Request $request){
    //     $data=$request->json()->all();
    //     $createdMaterials = [];
    //     foreach($data as $materialData){
    //         $material=Material::create([
    //             'name' =>$materialData['name'],
    //             'address' =>$materialData['address'],
    //             'product_id' =>$materialData['product_id'],
    //             'material_parent' =>null,
    //         ]);
    //         if(isset($materialData['children'])&& is_array($materialData['children'])){
    //             $this->addChildren($material,$materialData['children']);
    //             $material['children'] = $this->buildHierarchy($material->id);
    //         }
    //         $hierarchicalData[] = $material;
    //     }
    //     return response()->json(['success' => true,'data' => $hierarchicalData], 201);
    // }
    public function buildHierarchy(Material $material, $materials) {
        $data = $material->toArray();
        $children = [];
        foreach ($materials as $childMaterial) {
            if ($childMaterial->material_parent == $material->id) {
                $children []= $this->buildHierarchy($childMaterial, $materials);
            }
        }
    
        if (!empty($children)) {
            $data['children'] = $children;
        }
        // dd($data);
        return $data;
    }

    // public function addChildren(Material $parentMaterial,array $children){
    //     foreach ($children as $childData) {
    //         $childMaterial=new Material([
    //             'name' =>$childData['name'],
    //             'address' =>$childData['address'],
    //             'product_id' =>$childData['product_id'],
    //         ]);
    //         $parentMaterial->children()->save($childMaterial);
    //         if (isset($childData['children']) && is_array($childData['children'])) {
    //             $this->addChildren($childMaterial, $childData['children']);
    //         }
    //     }
    // }
    public function edit(Request $request,$id){
        $material=Material::find($id);
        if(!$material){return response()->json(['success' => false,'error'=>'material not found'],404);}
        $material->update([
            'name'=> $request->input('name'),
            'address' => $request->input('address'),
            'product_id' => $request->input('product_id'),
            ]);
            if ($request->has('children') && is_array($request->input('children'))) {
                $this->updateChildren($material, $request->input('children'));
            }
            $hierarchicalData = $this->buildHierarchy($material->id);
            return response()->json(['success' => true, 'data' => $hierarchicalData], 200);
        }
    protected function updateChildren(Material $parentMaterial, array $children){
        $parentMaterial->children()->delete();
        foreach ($children as $childData) {
            $childMaterial = new Material([
                'name' => $childData['name'],
                'address' => $childData['address'],
                'product_id' => $childData['product_id'],
            ]);
            $parentMaterial->children()->save($childMaterial);
            if (isset($childData['children']) && is_array($childData['children'])) {
                    $this->updateChildren($childMaterial, $childData['children']);
            }
            }
        }
    public function delete($id){
        $material=Material::find($id);
        if(!$material){return response()->json(['error'=>'material not found'],404);}
        $material->delete();
        return response()->json('Deleted Successfully');
    }
    public function get() {
        $materials = Material::whereNull('material_parent')->with('children')->get();
        $hierarchicalData = [];
    
        foreach ($materials as $material) {
            $hierarchicalData[] = $this->buildHierarchy($material, $materials);
        }
    
        return response()->json(['success' => true, 'data' => $hierarchicalData], 200);
    }
    public function getMaterials($id){
        $product=Product::find($id);
        if(!$product){
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        $materials = $product->materials()->with('children')->get();
        $Data = [];
        foreach ($materials as $material) {
            if($material->material_parent===null){
                $Data[] = $this->buildHierarchy($material,$materials);
            }
           
        }
        return response()->json(['success'=>true,'data'=>$Data],200);
    }
}
