<?php

namespace App\Http\Controllers;

use  App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        Company::selection()->orderBy('id')->get();
    }
    public function adding(Request $request){
        $items=new Company();
        $items->name=$request->name;
        $items->address=$request->address;
        $items->description=$request->description;
        $items->user_id=$request->user_id;
        $items->save();
        return response()->json('Added Successfully');

    }
    public function edit(Request $request){
        $items=Company::findorfail($request->id);
        $items->name=$request->name;
        $items->address=$request->address;
        $items->description=$request->description;
        $items->user_id=$request->user_id;
        $items->update();
        return response()->json('Updated Successfully');
    }
    public function delete(Request $request){
        $items=Company::findorfail($request->id);
        $items->delete();
        return response()->json('Deleted Successfully');
    }
    public function getData(){
        $items=Company::all();
        return response()->json($items);
    }
}
