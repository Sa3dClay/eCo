<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wish_List;

class wish_listController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $WL = new Wish_List;
            $WL->user_id = Auth::user()->id ;
            $WL->pro_id = $request->input('id') ;
            $WL->save();
            return redirect('/products')->with('success', "Product is added to your wish list successfuly");
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


    public function remove_from_WishList($pro_id) {
        if( isset(Auth::user()->id) ) {
            // $product = Cart::findBy($pro_id, Auth::user()->id);
            $check = DB::table('wishlist')->where([
                ['user_id', '=', Auth::user()->id],
                ['pro_id', '=', $pro_id],
            ])->delete();

            if( $check ) {
                return redirect("/products")->with("success", "The product has been removed from your wish list");
            }
            else {
                return redirect("/cart")->with("error", "Error with last action");
            }

        } else {
            return redirect("/cart")->with("error", "Unauthorized action");
        }
    }

    public static function checkAdded()
    {
        if(!Auth::guest() && Auth::user()->is_admin != 1)
        {
            $cart = Cart::select(['wishlist'])->where('user_id', Auth::user()->id)->get()->toArray();
            
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

}
