<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function show(){
    $user = User::find(auth()->user()->id);

    $cart = CartController::checkAdded();
    $wl = wish_listController::checkAdded();
    $countNew = NotificationController::checkAdded();

    $data = [
        'user' => $user,
        'cartpros' => $cart,
        'wishlistProducts' => $wl,
        'countNew' => $countNew
    ];

    return view('user.show')->with($data);
  }

  public function update(Request $request){
  
  }
}
