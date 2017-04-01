<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /*
     * Group has many user
     */
    public function users(){
        return $this->belongsToMany('App\Models\User','group_user','group_id','user_id');
    }
}