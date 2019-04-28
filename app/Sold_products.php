<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sold_products extends Model
{
    protected $table="sold_products";
    public $timestumps=true;

    public function invoice(){
        return $this->belongsTo("App\Invoice");
    }

}
