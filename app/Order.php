<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{
    protected $table="orders";
    public $primaryKey="id";
    public $timestumps=true;

    public function user(){
        return $this->belongsTo("App\Invoice");
    }

    public static function get_products($invoice_id){
      return DB::table('orders')
        ->join('products', function($join) use($invoice_id)
        {
            $join->on('orders.product_id', '=', 'products.id')->where('orders.invoice_id', '=', $invoice_id);
        })->get();
    }

}
