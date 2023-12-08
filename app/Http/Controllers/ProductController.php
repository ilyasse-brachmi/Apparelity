<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use MediaUploader;



class ProductController extends Controller
{
    public function add(Request $request){
        $request->validate([
            'name' => ['required','string', 'max:40'],
            'price'=>['required','string', 'numeric'],
            'description'=>['max:255','string'],
            'production_date' =>'required',
            'company_id' => 'required',
            'category_id' => 'required',
            'image_product' => ['mimes:png,jpg,jpeg,gif','required'],
        ]);

        $product=Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'production_date'=>$request->production_date,
            'company_id'=>$request->company_id,
            'category_id'=>$request->category_id,
        ]);

        if ($request->hasFile('image_product')) {

            if ($product->hasMedia('image_product')) {
                $product->firstMedia('image_product')->forceDelete();
            }
            $media = MediaUploader::fromSource($request->file('image_product'))
                ->toDestination('local', 'home')
                ->useFilename(Str::uuid())
                ->makePrivate()
                ->onDuplicateReplace()
                ->upload();
            $product->attachMedia($media, 'image_product');
        }
        return response()->json('Added Successfully');

    }
    public function edit(Request $request){
        $request->validate([
            'name' => ['required','string', 'max:40'],
            'price'=>['required','string', 'numeric'],
            'description'=>['max:255','string'],
            'production_date' =>'required',
            'company_id' => 'required',
            'category_id' => 'required',
            'image_product' => ['mimes:png,jpg,jpeg,gif',Rule::requiredif(empty($this->route()->parameter('id')))],
        ]);

        $product=Product::findorfail($request->id);
        $product->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'production_date'=>$request->production_date,
            'company_id'=>$request->company_id,
            'category_id'=>$request->category_id,
        ]);

        if ($request->hasFile('image_product')) {
            if ($product->hasMedia('image_product')) {
                $product->firstMedia('image_product')->forceDelete();
            }
            $media = MediaUploader::fromSource($request->file('image_product'))
                ->toDestination('local', 'home')
                ->useFilename(Str::uuid())
                ->makePrivate()
                ->onDuplicateReplace()
                ->upload();
            $product->attachMedia($media, 'image_product');
        }
        return response()->json('Updated Successfully');
    }
    public function delete(Request $request){
        $product=Product::findorfail($request->id);
        $product->materials()->delete();
        $product->delete();
        return response()->json('Deleted Successfully');
    }
    public function get(){
        $products=Product::all();
        $data=[];
        foreach ($products as $key=>$product){
            $data[$key]= (new \App\Models\Product)->convertToArray($product);
        }
        return response()->json($data);
    }
}
