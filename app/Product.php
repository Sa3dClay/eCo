<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table="products";    
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
    
    public static function find_no_space($str2){
        $products=DB::select("SELECT DISTINCT * from products where LOWER(name) LIKE'$str2%' or LOWER(brand) LIKE'$str2%' or LOWER(category) LIKE'$str2%' order by n_sold desc");
        return $products;
    }
    
    public static function find_space($words){
        $products=DB::select("SELECT DISTINCT * FROM products WHERE LOWER(name) in ($words) OR LOWER(brand) in ($words) OR LOWER(category) in ($words) order by n_sold desc");
        return $products;
    }
}
