<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'email'=>'required|email',
            'password'=>'required'
        ]);
    }
}
