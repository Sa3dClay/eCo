<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table="invoice";
    public $primaryKey="id";
    public $timestumps=true;

    public function user(){
        return $this->belongsTo("App\User");
    }

    public function products(){
        return $this->hasMany("App\Product");
    }

    public function orders(){
        return $this->hasMany("App\Order");
    }
}
