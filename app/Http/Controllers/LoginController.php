<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
class LoginController extends Controller
{
    /*
     * Login function
     */
    public function getLogin(Request $request){
        return view("login.login");
    }
    public function postLogin(Request $request){
        $this->validate($request,[
            'email'=>'required|email|exists:users',
            'password'=>'required'
        ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return "succ";
        }


    }
}
