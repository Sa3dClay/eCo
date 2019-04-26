<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
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
        

        if( isset(Auth::user()->id) ) {
            
            $cartController = new CartController;
            $products = $cartController->getAllCartProducts();
            $totalCost = $cartController->getTotalCost();

            $total_Cost_For_Each_Product = array();

            foreach($products as $pro) {
              //  $total_Cost_For_Each_Product[$pro->id] = $pro->price * $pro->n_of_pro;
              array_push($total_Cost_For_Each_Product , $pro->price * $pro->n_of_pro);
            }

            $data = [
                'products' => $products,
                'subTotalCost' => $totalCost,
                'totalCost_per_prodcut' => $total_Cost_For_Each_Product,
                'eCoPercintage' => "15%",
                'totalCost' => $totalCost + ( $totalCost * 0.15 ) 
            ];

            return view('invoice.create_invoice')->with($data);
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
}
