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
      $user = User::find(auth()->user()->id);
      $user->name = $request->input('name');
      $user->phone_number = $request->input('phone_number');
      $user->country = $request->input('country');
      $user->city = $request->input('city');
      $user->address = $request->input('address');
      $user->zip_code = $request->input('zip_code');
      if($user->save()){
        return redirect('/products')->with('success','Your account has been updated');
      }else{
        return redirect('/products')->with('error',"Can't update updated your account");
      }
  }
}
