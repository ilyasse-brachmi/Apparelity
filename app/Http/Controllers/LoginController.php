<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\Mime\to;

class loginController extends Controller
{
    public function show() {
        return view('login.show');
    }
    public function login(Request $request){
        $email=$request->email;
        $password=$request->password;
        $credentials=['email'=>$email,"password"=>$password];
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return true;
        }else{
                return back()->withErrors([
                    'email'=>'Email or Password are not valid'
                ])->onlyInput('email');

        }
    }
}
