<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Notifications;
use App\User;

class UserController extends Controller
{
  use Notifications;

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

  public function verify($code){
      $user = User::where('verif_code', $code)->first();
      if(!isset($user)){
         return redirect('/products')->with('error', 'link has been expired');
      }
      $user->email_verified_at = date("Y-m-d H:i:s");
      if($user->save()){
        $this->verifiedEmail($user->id,'normal');
        return redirect('/products')->with('success', 'Your email has been verified');
      }else{
        return redirect('/products')->with('error', 'Couldn\'t verify your email');
      }
  }
}
