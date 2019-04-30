<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerDashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $countNew = NotificationController::checkAdded();
        return view('dashboards.seller.index')->with('countNew',$countNew);
    }
}
