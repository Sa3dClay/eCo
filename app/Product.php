<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $tabel="products";    
    public $primaryKey="id";
    public $timestumps=true;
    
    public function user(){
        return $this->belongsTo("App\User");
    }
    
    public function cart(){
        return $this->belongsTo("App\Cart");
    }

    public function invoice(){
        return $this->belongsTo("App\Invoice");
    }
}
