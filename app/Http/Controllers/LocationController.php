<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function countries(){
        $countries = getCountriesNames();
        $data=[];
        foreach ($countries as $key=>$value){
            $data[]=['key' => $key, 'value' => $value];
        }
        return response()->json($data);
    }
    public function states(Request $request){
        $codeIso=$request->codeIso;
        $states=getStates($codeIso);
        $data=[];
        foreach ($states as $key=>$value){
            $data[]=['key' => $key, 'value' => $value];
        }
        return response()->json($data);
    }
}
