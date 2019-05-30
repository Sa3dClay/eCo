<?php

namespace App\Http\Controllers;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use App\Order;
use App\Invoice;
use App\User;

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

     public function index($invoice_id){
        $invoice=Invoice::find($invoice_id);
        $total_cost = $invoice->total_cost;
        $status = $invoice->status;
        $products = Order::get_products($invoice_id);
        $user=User::find($invoice->user_id);

        $countNew = NotificationController::checkAdded();

        $data = [
            'products' => $products,
            'totalCost' => $total_cost,
            'status' => $status,
            'user' => $user,
            'eCoPercintage' => '5%',
            'countNew' => $countNew
        ];
        return view('orders.index')->with($data);
     }

    public function make_order($invoice_id,$products){
      foreach ($products as $product) {
        $order=new Order;
        $order->invoice_id=$invoice_id;
        $order->product_id=$product->id;
        $order->n_of_pro=$product->n_of_pro;
        $order->save();
      }
    }

}
