<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Company;

class AuthController extends Controller
{
    public function show() {
        return view('welcome');
    }

    public function login(Request $request){
        $email=$request->email;
        $password=$request->password;
        $credentials=['email'=>$email,'password'=>$password];
        if(!auth()->attempt($credentials)) {
            return response()->json(['message' => 'données invalide'],201); 
        }
        $user=Auth::User();
        $token=$user->createToken('user')->plainTextToken;
        return response(['user'=>$user,'token'=>$token]);     
    }

    public function register(Request $request){
        $user = new User;
        $user->email=$request->input('email');
        $user->phone=$request->input('phone');
        $user->password=bcrypt($request->input('password'));
        $user->save();
        $Company = new Company;
        $Company->user_id=$user->id;
        $Company->name=$request->input('name');
        $Company->address=$request->input('address');
        $Company->description=$request->input('description');
        $Company->save();
        $token=$Company->createToken('company')->plainTextToken;
        return response(['company'=>$Company,'token'=>$token]);
    }
    public function logout(){
        $user=Auth::User();
        $user->currentAccessToken()->delete();
        return response()->json(['message'=>'successfully logged out']);
    }
}


