<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table="cart";    
    public $primaryKey="id";
    public $timestumps=true;
    
    public function user(){
        return $this->belongsTo("App\User");
    }
    
    public function products(){
        return $this->hasMany("App\Product");
    }
    
    public static function findBy($id1,$id2){
        return Cart::where("pro_id","=",$id1,'and','user_id','=',$id2)->take(1);
    }
}
