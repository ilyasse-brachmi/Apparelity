<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\Mime\to;

class registerController extends Controller
{
    public function show() {
        return view('welcome');
    }
    // public function register(Request $request){
    //     $email=$request->email;
    //     $password=$request->password;
    //     $credentials=['email'=>$email,"password"=>$password];
    //     if(Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return true;
    //     }else{
    //             return back()->withErrors([
    //                 'email'=>'Email or Password are not valid'
    //             ])->onlyInput('email');

    //     }
    // }
}
