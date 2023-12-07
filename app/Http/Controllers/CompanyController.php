<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use  App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function add(CompanyRequest $request){

        Company::create([
            'name'=>$request->name,
            'address'=>$request->address,
            'description'=>$request->description,
            'user_id'=>$request->user_id,
            'zipCode'=>$request->zipCode,
            'county'=>$request->county,
            'city'=>$request->city,
            'phone'=>$request->phone,
        ]);
        return response()->json('Added Successfully');

    }
    public function edit(CompanyRequest $request){
        $category=Company::findorfail($request->id);
        $category->update([
            'name'=>$request->name,
            'address'=>$request->address,
            'description'=>$request->description,
            'user_id'=>$request->user_id,
            'zipCode'=>$request->zipCode,
            'county'=>$request->county,
            'city'=>$request->city,
            'phone'=>$request->phone,
        ]);
        return response()->json('Updated Successfully');
    }
    public function delete(CompanyRequest $request){
        $company=Company::findorfail($request->id);
        $company->delete();
        return response()->json('Deleted Successfully');
    }
    public function get(){
        $company=Company::all();
        return response()->json($company);
    }
}
