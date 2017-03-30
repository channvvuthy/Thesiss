<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /*
     * admin index
     */
    public function getIndex(){
        return view('admin.index');
    }
    public function  getCreateUser(Request $request){
        return view('admin.user');
    }
    public function getCreateGroup(){
        return view('admin.group');
    }
}
