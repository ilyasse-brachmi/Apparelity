<?php

namespace App\Http\Controllers;

use  App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function add(Request $request){

        Company::create([
            'name'=>$request->name,
            'address'=>$request->address,
            'description'=>$request->description,
            'user_id'=>$request->user_id,
<<<<<<< Updated upstream
=======
            'zipCode'=>$request->zipCode,
            'county'=>$request->county,
            'city'=>$request->city,
            'phone'=>$request->phone, 
>>>>>>> Stashed changes
        ]);
        return response()->json('Added Successfully');

    }
    public function edit(Request $request){
        $category=Company::findorfail($request->id);
        $category->update([
            'name'=>$request->name,
            'address'=>$request->address,
            'description'=>$request->description,
            'user_id'=>$request->user_id,
<<<<<<< Updated upstream
=======
            'zipCode'=>$request->zipCode,
            'county'=>$request->county,
            'city'=>$request->city,
            'phone'=>$request->phone, 
>>>>>>> Stashed changes
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
