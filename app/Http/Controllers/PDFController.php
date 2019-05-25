<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
   public $products;
   private $user;
   private $total;

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function __set($name, $value) {
      switch($name) {
          case 'products':
              $this->products = $value;
              break;
          case 'user':
              $this->user = $value;
              break;
          case 'total':
              $this->total = $value;
              break;
      }
  }
  // public function set_products($products){
  //   PDFController::$products=$products;
  // }
  // public function set_user($user){
  //   PDFController::$user=$user;
  // }
  // public function set_total($total){
  //   PDFController::$total=$total;
  // }

  public function loadPDF(){
    $pdf = PDF::loadView('invoicePDF',$this->collect_data());
    return $pdf->download('invoice'.date("y/m/d h:m:s").'.pdf');
   //return redirect('/products')->with('success', 'Your order is submited ,you will receive the order in 5 days of work');
  }

  private function collect_data(){
      $data = [
        'products'=> $this->products,
        'total'=> $this->total,
        'user'=> $this->user
      ];

      return $data;
  }
}
