<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use MediaUploader;
use function PHPUnit\Framework\status;
use Illuminate\Validation\ValidationException;
class ProductController extends Controller
{
    public function validateProductData(Request $request){
        $rules = [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'production_date' => 'required|date',
            'company_id' => 'required|exists:company,id',
            'category_id' => 'required|exists:category,id',
            'image_product' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()],422);
        }
    }
    public function add(Request $request)
    {
        $validation = $this->validateProductData($request);
        if ($validation !== null) {
            return $validation;
        }

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'production_date' => $request->production_date,
            'company_id' => $request->company_id,
            'category_id' => $request->category_id,
        ]);
        
        $companyName = $product->company->name;
        $categoryName = $product->category->name; 
        if ($request->hasFile('image_product')) {
            $this->uploadProductImage($product, $request->file('image_product'));
        }
        $materialsData = json_decode($request->input('materials'), true);
        $this->addMaterials($product,$materialsData);
        $materials = $product->materials()->with('children')->get();
        $Data = [];
        foreach ($materials as $material) {
            if($material->material_parent===null){
                $Data[] = $this->buildHierarchy($material,$materials);
            }
        }
        return response()->json([
        'success' => true,
        'product' => [
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'production_date' => $product->production_date,
            'company_id' => $product->company_id,
            'company_name' => $companyName,
            'category_id' => $product->category_id,
            'category_name' => $categoryName,
            'updated_at' => $product->updated_at,
            'created_at' => $product->created_at,
            'id' => $product->id,
            'product_image'=>$product->getPicAttribute(),
            'materials' => $Data,
        ]
        ]);
    }
    public function uploadProductImage(Product $product, $file){
        if ($product->hasMedia('image_product')) {
            $product->firstMedia('image_product')->forceDelete();
        }
        $media = MediaUploader::fromSource($file)
                ->toDestination('local', 'public')
                ->useFilename(Str::uuid())
                ->makePrivate()
                ->onDuplicateReplace()
                ->upload();
            $product->attachMedia($media, 'image_product');
    }
    public function addMaterials(Product $product, array $materialsData){
        $rules = [
            'name' => 'required|string',
            'address' => 'required|string',
            'children' => 'sometimes|array',
            'children.*.name' => 'required|string',
            'children.*.address' => 'required|string',
        ];
        foreach ($materialsData as $materialData) {
            $validator = Validator::make($materialData, $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }    
            $material = Material::create([
                'name' => $materialData['name'],
                'address' => $materialData['address'],
                'product_id' => $product->id,
            ]);
        if (isset($materialData['children']) && is_array($materialData['children'])) {
            $this->addChildren($material, $materialData['children']);
        }
        }
    }
    public function addChildren(Material $parentMaterial, array $children){
        foreach ($children as $childData) {
            $childMaterial = new Material([
                'name' => $childData['name'],
                'address' => $childData['address'],
                'product_id' => $parentMaterial->product_id,
            ]);
            $parentMaterial->children()->save($childMaterial);
        if (isset($childData['children']) && is_array($childData['children'])) {
            $this->addChildren($childMaterial, $childData['children']);
        }
        }
    }

    public function buildHierarchy(Material $material,$materials) {
        $data = $material->toArray();
        $children = [];
        foreach ($materials as $childMaterial) {
            if($childMaterial->material_parent==$material->id){
            $children[] = $this->buildHierarchy($childMaterial,$materials);
            }}
        if (!empty($children)) {
            $data['children'] = $children;
        }
        return $data;
    }
    
    public function edit(Request $request, $id)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'name' => ['required', 'string', 'max:40'],
            'price' => ['required', 'string', 'numeric'],
            'description' => ['max:255', 'string'],
            'production_date' => 'required',
            'company_id' => 'required',
            'category_id' => 'required',
            'image_product' => ['image', 'mimes:jpeg,jpg,png', 'max:2056']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->messages()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'production_date' => $request->production_date,
            'company_id' => $request->company_id,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('image_product')) {
            if ($product->hasMedia('image_product')) {
                $product->firstMedia('image_product')->forceDelete();
            }
            $media = MediaUploader::fromSource($request->file('image_product'))
                ->toDestination('local', 'public')
                ->useFilename(Str::uuid())
                ->makePrivate()
                ->onDuplicateReplace()
                ->upload();
            $product->attachMedia($media, 'image_product');
        }
        return response()->json('Updated Successfully');
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->materials()->delete();
        $product->delete();
        return response()->json('Deleted Successfully');
    }

    //*******************************************Getters *************************************
    public function get()
    {
        $products = Product::all();
        $data = [];
        foreach ($products as $key => $product) {
            $data[$key] = (new \App\Models\Product)->convertToArray($product);
        }
        return response()->json($data);
    }

    public function getProductCompany($id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }
        $products = $company->products;
        $data = [];
        foreach ($products as $key => $product) {
            $data[$key] = (new \App\Models\Product)->convertToArray($product);
        }
        return response()->json($data);
    }
    //***************************************End Getters *************************************

    //******************************Search Functions *************************
    public function search(Request $request)
    {
        $companyName = $request->input('company');
        $productName = $request->input('product');
        if ($companyName) {
            $company = Company::where('name', 'like', "%$companyName%")->first();
            $productsCompany = Product::where('company_id', $company->id)->get();
            $data = [];
            foreach ($productsCompany as $key => $product) {
                $data[$key] = (new \App\Models\Product)->convertToArray($product);
            }
            if ($company) {
                return response()->json($data);
            } else {
                return response()->json(['error' => 'Company not found'], 404);
            }
        }
        if ($productName) {
            $products = Product::where('name', 'like', "%$productName%")->get();
            $data = [];
            foreach ($products as $key => $product) {
                $data[$key] = (new \App\Models\Product)->convertToArray($product);
            }
            if ($products->isNotEmpty()) {
                return response()->json($data);
            } else {
                return response()->json(['error' => 'Product not found'], 404);
            }
        }
        return response()->json(['error' => 'Please provide a company or product name for search'], 400);
    }

    public function searchInCompany($companyId, $nameProduct)
    {
        $company = Company::find($companyId);
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }
        $products = $company->products()->where('name', 'like', "%$nameProduct%")->get();
        $data = [];
        foreach ($products as $key => $product) {
            $data[$key] = (new \App\Models\Product)->convertToArray($product);
        }
        if ($products->isNotEmpty()) {
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Product not found for the specified company and name'], 404);
        }
    }
    //*************************************************End Search Functions *****************************************************************
}