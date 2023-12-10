<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function countries(){
        $countries = getCountriesNames();
        return response()->json($countries);
    }
    public function states(Request $request){
        $codeIso=$request->codeIso;
        $states=getStates($codeIso);
        return response()->json($states);
    }
}
