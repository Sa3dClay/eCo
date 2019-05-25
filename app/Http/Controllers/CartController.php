<?php

namespace App\Http\Controllers;

use DB;
use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Constructor
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Here we will get all products that in customer cart, and also get all info fer each product -> inner join
        if( isset(Auth::user()->id) ) {

            $products = $this->getAllCartProducts();
            $totalCost = $this->getTotalCost();

            $data = [
                'products' => $products,
                'totalCost' => $totalCost
            ];

            return view('cart.index')->with($data);
        } else {
            return redirect('/')->with('error', 'You are not authorized to show this page');
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
        if(!Auth::guest() && Auth::user()->is_admin != 1)
        {
            $cart = new Cart;

            $cart->user_id = Auth::user()->id ;
            $cart->pro_id = $request->input('id') ;
            $cart->n_of_pro = 1;
            $cart->save();

            return back()->with('success', "Product was added to cart successfully");
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
    public function update(Request $request, $productId)
    {
        $quantity = $request->input('qty');
        DB::table('cart')->where('user_id', Auth::user()->id)->where('pro_id' ,$productId)->update(['n_of_pro' => $quantity]);
        return redirect('/cart')->with("success","The cart was updated");
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

    // Check if the product in the cart
    public static function checkAdded()
    {
        if(!Auth::guest() && Auth::user()->is_admin != 1)
        {
            $cart = Cart::select(['pro_id'])->where('user_id', Auth::user()->id)->get()->toArray();

            // $cart = null;
            if($cart != null)
            {
                $result = array();
                foreach($cart as $c1)
                {
                    foreach($c1 as $key => $value)
                    {
                        array_push($result,$value);
                    }
                }

                return array_unique($result);
            }

        }
        return [];
    }

    // remove product from cart
    public function remove_from_cart($pro_id) {
        if( isset(Auth::user()->id) ) {

            $check = DB::table('cart')->where([
                ['user_id', '=', Auth::user()->id],
                ['pro_id', '=', $pro_id],
            ])->delete();

            if( $check ) {
                return back()->with("success", "The product has been removed from your cart");
            }
            else {
                return back()->with("error", "Error with last action");
            }

        } /*else if( Auth::guard('admin')->check() ) {
            $check = DB::table('cart')->where('pro_id', $pro_id)->delete();
            return $check;

        }*/ else {
            back()->with("error", "Unauthorized action");
        }
    }

    // remove product from all carts
    public function remove_from_all_carts($pro_id) {

        $check = DB::table('cart')->where('pro_id', $pro_id)->delete();

        return $check;
    }

    // This function will return all products belongs to the user
    public function getAllCartProducts() {
        $products = DB::table('products')->join('cart', function ($join) {
            $user_id = Auth::user()->id;

            $join->on('products.id', '=', 'cart.pro_id')
                ->where('cart.user_id', '=', $user_id);
        })->get();

        return $products;
    }

    // This function will return the total cost of the cart items
    public function getTotalCost() {
        if( isset(Auth::user()->id) ) {

            $products = $this->getAllCartProducts();

            $total = 0;
            // Get the summation of all products
            foreach($products as $pro) {
                $total += $pro->price * $pro->n_of_pro;
            }
            return $total;
        }
    }

    // Remove all products for users cart
    public function remove_all_from_cart()
    {

        if( isset(Auth::user()->id) ) {

            $products = $this->getAllCartProducts();

            foreach($products as $pro)
            {

                $check = DB::table('cart')->where([
                    ['user_id', '=', Auth::user()->id],
                    ['pro_id', '=', $pro->id],
                ])->delete();

                if( $check ) {
                    continue;
                }
                else {
                    return view('ERROR WITH REMOVING CART');
                }

            }

        } else {
            back()->with("error", "Unauthorized action");
        }
    }

}
