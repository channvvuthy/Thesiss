<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    public  function variation(){
        return $this->belongsTo('App\Models\Variation');
    }
}
