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
}
