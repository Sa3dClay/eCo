<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Auth;
use App\Sold_products;
use App\Invoice;
use App\User;
use App\Mail\verify;
use App\Traits\Notifications;
use Mail;

class InvoiceController extends Controller
{
    private $cartController;
    use Notifications;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
         $this->cartController = new CartController;
         $this->middleware('auth',['only'=>['get_my_invoices']]);
         $this->middleware('admin',['only'=>['index','set_status']]);
     }

    public function index()
    {
      if(Auth::guard('admin')->user()->role == 'admin'){
        $invoices=Invoice::orderBy('created_at','asc')->get();

        $countNew = NotificationController::checkAdded();

        $data = [
            'invoices' => $invoices,
            'countNew' => $countNew
        ];

        return view('invoice.index')->with($data);
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
        if( isset(Auth::user()->id) ) {

          //if(!preg_match("/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}/", Auth::user()->email_verified_at) ){
          if(!isset(Auth::user()->email_verified_at)){
            $user = User::find(Auth::user()->id);
            try{
                Mail::to($user)->send(new verify);

                if(Mail::failures()){
                    return back()->with('error','You should verify your email to make an order,Can\'t send verification mail !');
                }else{
                    return back()->with('error','You should verify your email to make an order,check your email !');
                }
            }catch(\Swift_TransportException $e){
                return back()->with('error',"Can't connect google mail due to SMPT autentication error,
                please contact us via (Paystoreoss@gmail.com).");
            }
          }

          if(Auth::user()->blocked==1){
            return back()->with('error','Can\'t make this order,your account is blocked, contact us to solve this problem! ');
          }

            $products = $this->cartController->getAllCartProducts();
            $totalCost = $this->cartController->getTotalCost();

            $total_Cost_For_Each_Product = array();

            foreach($products as $pro) {
                //  $total_Cost_For_Each_Product[$pro->id] = $pro->price * $pro->n_of_pro;
                array_push($total_Cost_For_Each_Product , $pro->price * $pro->n_of_pro);
            }

            $cart = CartController::checkAdded();
            $wl = wish_listController::checkAdded();
            $countNew = NotificationController::checkAdded();
            $total=$totalCost + ( $totalCost * 0.05 );

            $data = [
                'cartpros' => $cart,
                'wishlistProducts' => $wl,
                'countNew' => $countNew,
                'products' => $products,
                'subTotalCost' => $totalCost,
                'totalCost_per_product' => $total_Cost_For_Each_Product,
                'eCoPercintage' => "5%",
                'totalCost' => $total
            ];

            if($total!=0){
              return view('invoice.create_invoice')->with($data);
            }else{
                return redirect('/products');
            }
        } else {
            return redirect('/')->with('error', 'You are not authorized to show this page');
        }

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
        if( !Auth::guest() ) {
            // Create Invoice
            $invoice = new Invoice;
            if($request->input('use_info')==1 && $this->check_for_recent()){
              $invoice=$this->use_recent_data($invoice);
            }else{
              $this->validate($request, [
                  'address' => 'required',
                  'country' => 'required',
                  'city' => 'required',
                  'phone_number' => 'required',
                  'zip_code' => 'required',
                  'payment_m' => 'required'
              ]);

              switch ($request->input('payment_m')) {
                  case 'Bank Account':
                      $this->validate($request, [
                          'bankNumber' => 'required'
                      ]);
                      $invoice->visaORacc  = $request->input('bankNumber');
                      break;
                  case 'Visa':
                      $this->validate($request, [
                          'visaNumber' => 'required'
                      ]);
                      $invoice->visaORacc  = $request->input('visaNumber');
                      break;
                  case 'PayPal':
                      $this->validate($request, [
                          'paypalAccount' => 'required'
                      ]);
                      $invoice->visaORacc  = $request->input('paypalAccount');
                      break;

                  default:
                      return view("error");
              }

              $invoice->user_id = Auth::user()->id;
              $invoice->address = $request->input('address');
              $invoice->country = $request->input('country');
              $invoice->city = $request->input('city');
              $invoice->phone_number = $request->input('phone_number');
              $invoice->zip_code = $request->input('zip_code');
              $invoice->payment_m = $request->input('payment_m');

              $this->update_recent_data($invoice);
            }
            //pdf
            $pdf=new PDFController();
            $pdf->products = $this->cartController->getAllCartProducts();
            $pdf->user= User::find(Auth::user()->id);

            $totalCost = $this->cartController->getTotalCost();
            $totalCost =$totalCost + ( $totalCost * 0.05 );
            $invoice->total_cost = $totalCost;

            $pdf->total=  $totalCost;
              // Store Invoice
            $invoice->save();
            $invoiceID = $invoice->id;
            // Add Sold Products
            $cart = new CartController;

            $products = $cart->getAllCartProducts();

            $order = new OrdersController;
            $order->make_order($invoiceID,$products);
            // Create object from product controller
            /*$proCtr = new ProductsController;

            foreach($products as $pro)
            {
                $soldProduct = new Sold_products;

                $soldProduct->product_id = $pro->id;
                $soldProduct->invoice_id = $invoiceID;
                $soldProduct->n_of_pro = $pro->n_of_pro;

                $soldProduct->save();

                // Remove a quantity of product from products table
                $proCtr->update_qunatity($pro->id, $pro->n_of_pro); //in OrdersController

                // Update number of sold items for each product
                $proCtr->update_nSold($pro->id, $pro->n_of_pro); //in OrdersController

            }*/
            // Removing all products from user's cart
            $cart->remove_all_from_cart();

            $this->userOrder(Auth::user()->id, $invoice->id, "normal");

            //redirect('/products')->with('success', 'Your order is submited ,you will receive the order in 5 days of work');
            //sleep(5);
            //print_r($pdf->product);
            return $pdf->loadPDF();
            //return redirect('/products')->with('success', 'Your order is submited ,you will receive the order in 5 days of work');

        } else {
            return redirect('/products')->with('error', 'You are not authorized to add product');
        }
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

    private function update_recent_data($invoice){
        User::where('id',Auth::user()->id)->update(array('address' => $invoice->address,
         'country' => $invoice->country, 'city' => $invoice->city, 'phone_number' => $invoice->phone_number,
          'zip_code' => $invoice->zip_code, 'payment_m'=> $invoice->payment_m, 'visaORacc' => $invoice->visaORacc));

    }

    private function use_recent_data($invoice){
      $user = User::find(Auth::user()->id);

      $invoice->user_id = $user->id;
      $invoice->address = $user->address;
      $invoice->country = $user->country;
      $invoice->city = $user->city;
      $invoice->phone_number = $user->phone_number;
      $invoice->zip_code = $user->zip_code;
      $invoice->payment_m = $user->payment_m;
      $invoice->visaORacc = $user->visaORacc;

      return $invoice;
    }

    private function check_for_recent(){
       $user = User::find(Auth::user()->id);
       if($user->visaORacc==null){
         return false;
       }
      return true;
    }

    // public static function collect_invoices(){
    //    return Invoice::all();
    // }

    public static function get_user_address($invoice_id){
         $user=Invoice::find($invoice_id)->user;
         $address=$user->country .','.$user->city.','.$user->address;
         return $address;
    }

    public function set_status($id,$status)
    {
       $invoice= Invoice::find($id);
       $user= Invoice::find($id)->user;
       $invoice->status=$status;
       //echo $id .','.$status;
       if($invoice->save()){
           $this->changeStatus($user->id, $status, $id, "normal");
           return redirect('invoice')->with('success', 'the order is In '.$status.' status Now'); //Shipping or canceled or shipped
      } else{
           return redirect('invoice')->with('error', 'Can\'t change the order\'s status');
      }
    }

    public function get_my_invoices(){
      $invoices = Invoice::where('user_id',auth::user()->id)->orderBy('created_at','asc')->get();

      $cart = CartController::checkAdded();
      $wl = wish_listController::checkAdded();
      $countNew = NotificationController::checkAdded();

      $data = [
          'cartpros' => $cart,
          'wishlistProducts' => $wl,
          'invoices' => $invoices,
          'countNew' => $countNew
      ];

      return view('invoice.my_invoices')->with($data);
    }
}
