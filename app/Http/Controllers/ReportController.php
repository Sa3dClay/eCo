<?php

namespace App\Http\Controllers;

use App\Report;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('admin',['only'=>['destroy','index']]);
        $this->middleware('auth',['only'=>['create','store']]);
    }

    public function index()
    {
       if(Auth::guard('admin')->user()->role == 'admin'){
            $reports=Report::orderBy('created_at','asc')->get();

            $countNew = NotificationController::checkAdded();

            $data = [
                'reports' => $reports,
                'countNew' => $countNew
            ];
            return view('reports.index')->with($data);
       }else{
           return redirect('/')->with("error","You are not authorized to view this page");
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $cart = CartController::checkAdded();
      $wl = wish_listController::checkAdded();
      $countNew = NotificationController::checkAdded();

      $data = [
          'cartpros' => $cart,
          'wishlistProducts' => $wl,
          'countNew' => $countNew
      ];

        return view('reports.create.create')->with($data);
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
        // $id = User::where('email', $request->input('email'))->pluck('id')->first();
        $report = new Report;
        $report->user_id = Auth::user()->id;
        $report->message = $request->input('message');

        if($report->save())
            return redirect('contact')->with('success', 'Your message has been sent');
        else
            return redirect('contact')->with('error', 'We could not send your message');

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
       if(Auth::guard('admin')->user()->role == 'admin'){
            $report= Report::find($id);
            $report->delete();
            return redirect('/reports')->with("success","The report was marked as seen");
       }else{
           return redirect('/')->with("error","Can't mark this report as SEEN");
       }
    }
}
