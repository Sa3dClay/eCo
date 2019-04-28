<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      if(Auth::guard('admin')->check()){
        $notifications=Notification::where([['user_id','=',Auth::guard("admin")->user()->id],
                                     ['user_role','!=','normal']])->orderBy('created_at','desc')->get();
        $this->mark_last_view(0);
      }else if(!Auth::guest()){
        $notifications=Notification::where([['user_id','=',Auth::user()->id],
                                     ['user_role','=','normal']])->orderBy('created_at','desc')->get();
        $this->mark_last_view(1);
      }else{
        return redirect('/')->with('error', 'Authentication error');
      }
      $cart = CartController::checkAdded();
      $wl = wish_listController::checkAdded();
      //$countNew = NotificationController::checkAdded();

      $data = [
          'notifications' => $notifications,
          'cartpros' => $cart,
          'wishlistProducts' => $wl,
          //'countNew' => $countNew
      ];
        return view('notifications.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //  date("Y-m-d h:m:s");
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

    public static function checkAdded()
    {
        $countNew=0;
        if(Auth::guard('admin')->check())
        {
            $notes = Notification::where([['user_id','=',Auth::guard("admin")->user()->id],
                                         ['user_role','!=','normal']])->get();
        }else if(!Auth::guest()){
            $notes = Notification::where([['user_id','=',Auth::user()->id],
                                           ['user_role','=','normal']])->get();
        }
        if(isset($notes)){
          foreach ($notes as $note) {
                  if($note->created_at>$note->updated_at){
                    $countNew++;
                  }
          }
        }
        return $countNew;
    }

    private function mark_last_view($check){ # 1 for a normal user & 0 for an admin&seller
      if($check==0){
        Notification::where([['user_id','=',Auth::guard("admin")->user()->id],
                                     ['user_role','!=','normal']])->update(array('updated_at' => date("Y-m-d h:m:s")));
      }else{
        Notification::where([['user_id','=',Auth::user()->id],
                                     ['user_role','=','normal']])->update(array('updated_at' => date("Y-m-d h:m:s")));
      }
    }

}
