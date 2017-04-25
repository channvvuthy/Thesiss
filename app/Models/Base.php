<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    public function pattern(){
        return $this->belongsToMany("App\Models\Pattern");
    }
    public function variation(){
        return $this->belongsToMany("App\Models\Variation");
    }
}
