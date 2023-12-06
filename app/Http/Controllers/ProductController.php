<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use MediaUploader;



class ProductController extends Controller
{
    public function add(ProductRequest $request){
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
    public function edit(ProductRequest $request){
        $product=Product::findorfail($request->id);
        $product->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'production_date'=>$request->production_date,
            'company_id'=>$request->company_id,
            'category_id'=>$request->category_id,
        ]);
        return response()->json('Updated Successfully');
    }
    public function delete(ProductRequest $request){
        $product=Product::findorfail($request->id);
        $product->materials()->delete();
        $product->delete();
        return response()->json('Deleted Successfully');
    }
    public function get(){
        $items=Product::all();
        return response()->json($items);
    }
}
