<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wish_List extends Model
{
    public function products(){
        return $this->hasMany("App\Product");
    }
    
     public function users(){
        return $this->hasMany("App\User");
    }
}
