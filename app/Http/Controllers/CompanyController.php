<?php

namespace App\Http\Controllers;

use  App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CompanyController extends Controller
{   
    public function validateCompanyData(Request $request){
        $rules = [
            'name' => 'required|string|max:255|unique:company,name,'.$request->id,
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'zipCode' => 'required|string',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'user_id' => 'unique:company,user_id,' . $request->id
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()],422);
        }
        $record=Company::where('user_id',$request->user_id)->where('id', '!=', $request->id)->first();
        $name=Company::where('name',$request->name)->where('id', '!=', $request->id)->first();
        if($record){
            return response()->json(['success'=>false,'errors'=>['user_id'=>['A record with this user already exists']]],422);
        }else if($name){
            return response()->json(['success'=>false,'errors'=>['name'=>['A record with this name already exists']]],422);
        }
        return null;
    }
    public function add(Request $request){
            $validation = $this->validateCompanyData($request);
            if ($validation !== null) {
                return $validation;
            }
            $company = Company::create($request->all());  
            if(!$company){
                return response()->json(['success' => false, 'message' => 'Failed to add company'], 500);
            }
           return response()->json(['success' => true,'data' => $company], 201);
    }
    public function edit(Request $request){
            $validation=$this->validateCompanyData($request);
            if ($validation !== null) {
                return $validation;
            }
            $company=Company::find($request->id);
            if(!$company){return response()->json(['success' => false,'error'=>'Company not found'],404);}
            $data = $request->except('user_id');
            $company->update($data);
            return response()->json(['success' => true,'data' => $company], 201);
    }
    public function delete($id){
        $company=Company::find($id);
        if(!$company){return response()->json(['error'=>'Company not found'],404);}
        $company->products()->delete();
        $company->delete();
        return response()->json('Deleted Successfully');
    }
    public function get(){
        $company=Company::all();
        return response()->json($company);
    }

    public function getOneCompany($id){
        $company=Company::find($id);
        return response()->json($company);
    }
}
