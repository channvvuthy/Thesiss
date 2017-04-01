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
            foreach(Auth::user()->roles as $role){
                if($role->permission=='admin'){
                    return view('admin.index');
                }elseif($role->permission=='manager'){
                    return "manager";
                }elseif($role->permission=='leader'){
                    return "Leader";
                }elseif($role->permission=='member'){
                    return "member";
                }
            }

        }


    }


}
