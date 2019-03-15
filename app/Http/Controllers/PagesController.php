<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;

class PagesController extends Controller
{
    public function index() {
        $products = Product::orderBy('n_sold', 'desc')->get();
        return view('welcome')->with('products', $products);
    }
}
