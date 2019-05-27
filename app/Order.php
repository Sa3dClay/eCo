<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table="Orders";
    public $primaryKey="id";
    public $timestumps=true;

    public function user(){
        return $this->belongsTo("App\Invoice");
    }
}
