<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peport extends Model
{
    protected $table="report";    
    public $primaryKey="id";
    public $timestumps=true;
    
    public function user(){
        return $this->belongsTo("App\User");
    }
}
