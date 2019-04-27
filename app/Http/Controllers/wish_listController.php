<?php

namespace App\Http\Controllers;

use DB;
use App\Wish_List;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class wish_listController extends Controller
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
        // Here we will get all products that in customer wish list, and also get all info fer each product
        if( isset(Auth::user()->id) ) {
            
            $wl_products = $this->getWLProducts();
            $wl = $this->checkAdded();

            $data = [
                'wl_products' => $wl_products,
                'wishlistProducts' => $wl,
            ];

            return view('wishlist.index')->with($data);
        } else {
            return redirect('/')->with('error', 'You are not authorized to show this page');
        }
    }

    // This function will return all products belongs to the user from his wish list
    public function getWLProducts() {
        $products = DB::table('products')->join('wishlist', function ($join) {
            $user_id = Auth::user()->id;

            $join->on('products.id', '=', 'wishlist.pro_id')
                ->where('wishlist.user_id', '=', $user_id);
        })->get();

        return $products;
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
        if(!Auth::guest() && Auth::user()->is_admin != 1)
        {
            $WL = new Wish_List;
            $WL->user_id = Auth::user()->id ;
            $WL->pro_id = $request->input('id') ;
            $WL->save();
            return back()->with('success', "Product is added to your wish list successfuly");
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

            $check = DB::table('wishlist')->where([
                ['user_id', '=', Auth::user()->id],
                ['pro_id', '=', $pro_id],
            ])->delete();

            if( $check ) {
                return back()->with("success", "The product has been removed from your wish list");
            } else {
                return back()->with("error", "Error with last action");
            }

        } else if( Auth::guard('admin')->check() ) {
            $check = DB::table('wishlist')->where('pro_id', $pro_id)->delete();
            return $check;
            
        } else {
            return back()->with("error", "Unauthorized action");
        }
    }

    public static function checkAdded()
    {
        if(!Auth::guest() && Auth::user()->is_admin != 1)
        {
            $wl = Wish_List::select(['pro_id'])->where('user_id', Auth::user()->id)->get()->toArray();
            
            // $wishlist = null;
            if($wl != null)
            {
                $result = array();
                foreach($wl as $c1)
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
