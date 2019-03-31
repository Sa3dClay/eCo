<?php

namespace App\Http\Controllers;

use DB;
use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        // Here we will fet all products that in customer cart, and also get all info fer each product -> inner join
        if( isset(Auth::user()->id) ) {
            
            $products = DB::table('products')->join('cart', function ($join) {
                $user_id = Auth::user()->id;

                $join->on('products.id', '=', 'cart.pro_id')
                    ->where('cart.user_id', '=', $user_id);
            })->get();

            return view('cart.index')->with('products', $products);
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

         //   return $request->input('id') ;
            $cart = new Cart;
            $cart->user_id = Auth::user()->id ;
            $cart->pro_id = $request->input('id') ;
            $cart->n_of_pro = 1;
            $cart->save();
            return redirect('/products')->with('success', "Product was added to cart successfuly");
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


    public static function checkAdded()
    {
        if(!Auth::guest() && Auth::user()->is_admin != 1)
        {
            $cart = Cart::select(['pro_id'])->where('user_id', Auth::user()->id)->get()->toArray();
            
            //   $cart =null;
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
                
                return $result;
            }
            
        }
        return [];
    }

    public function remove_from_cart($id) {
        $product=Cart::find($id);

        if(Auth::user()->id==$product->user_id){
            $product->delete();
        }else{
            return redirect("/cart")->with("error","Authorization error");   
        }
        return redirect("/cart")->with("success","The product has been removed from your cart");
    }
}
