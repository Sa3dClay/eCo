<?php

namespace App\Http\Controllers;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use App\Order;
use App\Invoice;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
         $this->middleware('admin');
     }

    public static function make_order($invoice_id,$products){
      foreach ($products as $product) {
        $order=new $Order;
        $order->invoice_id=$invoice_id;
        $order->product_id=$product->id;
        $order->n_of_pro=$product->n_of_pro;
        $order->status="new";
        $order->save();
      }
    }

    public static function collect_orders($invoice_id){

    }

}
