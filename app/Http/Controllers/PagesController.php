<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Http\Controllers\CartController;

class PagesController extends Controller
{
    public function index() {
        $products = Product::orderBy('n_sold', 'desc')->get();
        $cart = CartController::checkAdded();
        $wl = wish_listController::checkAdded();
        $countNew = NotificationController::checkAdded();
        $data = [
            'products' => $products,
            'cartpros' => $cart,
            'wishlistProducts' => $wl,
            'countNew' => $countNew
        ];

        return view('welcome')->with($data);
    }
}
