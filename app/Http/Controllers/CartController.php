<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart.index');
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
}
