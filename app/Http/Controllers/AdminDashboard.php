<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Admin;

class AdminDashboard extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        return view('dashboards.admin.index');
    }

    public function showRegister() {
        return view('dashboards.auth.register');
    }

    public function showUsers() {
        return view('dashboards.admin.users.show');
    }

    public function addMembers() {

    }
}
