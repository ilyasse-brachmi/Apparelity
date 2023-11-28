<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Company;

class AuthController extends Controller
{

    public function login(Request $request){
        $email=$request->email;
        $password=$request->password;
        $credentials=['email'=>$email,'password'=>$password];
        if(!auth()->attempt($credentials)) {
            return response()->json(['errorMessage' => 'email or password not valid'] ,400); 
        }
        $user=Auth::User();
        $token=$user->createToken('user')->plainTextToken;
        return response()->json(['user'=>$user,'token'=>$token] ,200);
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


