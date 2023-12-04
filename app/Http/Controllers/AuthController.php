<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Company;

class AuthController extends Controller
{

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:30',
        ]);
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
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
<<<<<<< Updated upstream
            'phone' => 'required|string',
=======
>>>>>>> Stashed changes
            'password' => 'required|string|min:8|max:30',
        ]);
        $user = new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();
        $token=$user->createToken('user')->plainTextToken;
        return response(['user'=>$user,'token'=>$token]);
    }
    public function logout(){
        $user=Auth::User();
        $user->currentAccessToken()->delete();
        return response()->json(['message'=>'successfully logged out']);
    }
}


