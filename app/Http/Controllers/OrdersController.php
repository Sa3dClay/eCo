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

    public function index()
    {
      if(Auth::guard('admin')->user()->role == 'admin'){
        $invoices= InvoiceController::collect_invoices();
        $orders=Order::orderBy('created_at','asc')->get();

        $countNew = NotificationController::checkAdded();

        $data = [
            'orders' => $orders,
            'countNew' => $countNew
        ];
         return view('orders.index')->with($data);
       }else{
           return redirect('/')->with("error","You are not authorized to view this page");
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

    public function start_shipping($id)
    {
        //
    }

    public function set_status($id,$status)
    {
        //
    }
}
