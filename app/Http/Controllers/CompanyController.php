<?php

namespace App\Http\Controllers;

use  App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function add(Request $request){
        $request->validate([
            'name' => ['required', 'max:40'],
            'address'=>['required', 'max:255'],
            'description'=>['max:255','string'],
            'user_id' => 'required',
            'county'=>['required','string'],
            'city'=>['required','string'],
            'zipCode'=>['required'],
            'phone'=>['required','string'],
        ]);
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
    public function edit(Request $request){
        $request->validate([
            'name' => ['required', 'max:40'],
            'address'=>['required', 'max:255'],
            'description'=>['max:255','string'],
            'user_id' => 'required',
            'county'=>['required','string'],
            'city'=>['required','string'],
            'zipCode'=>['required'],
            'phone'=>['required','string'],
        ]);
        $company=Company::findorfail($request->id);
        $company->update([
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
    public function delete(Request $request){
        $company=Company::findorfail($request->id);
        $company->delete();
        return response()->json('Deleted Successfully');
    }
    public function get(){
        $company=Company::all();
        return response()->json($company);
    }
}
