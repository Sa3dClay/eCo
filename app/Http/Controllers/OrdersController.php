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
          //$user=User::find($invoice->user_id);
        if(count($products)>0){
          $countNew = NotificationController::checkAdded();

          $data = [
              'products' => $products,
              'totalCost' => $total_cost,
              'status' => $status,
              'user_id' => $invoice->user_id,
              'eCoPercintage' => '5%',
              'invoice_id' => $invoice->id,
              'countNew' => $countNew
          ];
          return view('orders.index')->with($data);
        }else{
          return back()->with("error","this order is empty");
        }
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

    public function make_pdf($invoice_id,$user_id,$totalCost){
        $pdf=new PDFController;
        $pdf->products = Order::get_products($invoice_id);
        $pdf->user = User::find($user_id);
        $pdf->total = $totalCost;
        return $pdf->loadPDF();
    }

}
