<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wish_List extends Model
{
    public function users(){
        return $this->belongsTo("App\User");
    }

    public function products(){
        return $this->hasMany("App\Product");
    }
}
