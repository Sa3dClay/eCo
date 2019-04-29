<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $cart = CartController::checkAdded();
      $wl = wish_listController::checkAdded();
      $countNew = NotificationController::checkAdded();

      $data = [
          'cartpros' => $cart,
          'wishlistProducts' => $wl,
          'countNew' => $countNew
      ];
        return view('home')->with($data);
    }
}
