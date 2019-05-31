<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table="notification";
    public $primaryKey="id";
    public $timestumps=true;

    public function user(){
        return $this->belongsTo("App\User");
    }

    public function Super_user(){
        return $this->belongsTo("App\Admin");
    }

}
