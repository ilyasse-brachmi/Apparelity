<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use MediaUploader;
use function PHPUnit\Framework\status;


class ProductController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:40'],
            'price' => ['required', 'string', 'numeric'],
            'description' => ['max:255', 'string'],
            'production_date' => 'required',
            'company_id' => 'required',
            'category_id' => 'required',
            'image_product' => ['image', 'mimes:jpeg,jpg,png', 'max:2056', 'required']
        ]);

        $product = Product::create([
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
        return response()->json('Added Successfully');

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

    public function delete(Request $request)
    {
        $product = Product::findorfail($request->id);
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