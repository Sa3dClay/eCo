<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sold_products extends Model
{
    protected $table="sold_products";
    public $timestumps=true;

    public function user(){
        return $this->belongsTo("App\Invoice");
    }

}
