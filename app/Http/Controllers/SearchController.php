<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Product;
use  App\Models\Company;
class SearchController extends Controller
{
    public function searchProducts(Request $request){
        $term=$request->input('search');
        $company=Company::where('name','like','%'.$term.'% COLLATE utf8mb4_general_ci')->first();
        if($company){
            $company_id=$company->id;
            $products=Product::where('company_id',$company_id)->get();
        }else{
            $products=Product::where('name','like','%'.$term.'% COLLATE utf8mb4_general_ci')->get();
        }
        return response()->json($products);
    }
}
