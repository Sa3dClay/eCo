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

    public function addMembers(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|min:6|confirmed',
        ]);

        $admin = new Admin();
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->password = bcrypt($request->input('password'));

        if($admin->save())
            return redirect('dashboard/admin/addmember')->withSuccess('Member has been added');
        else
            return redirect('dashboard/admin/addmember')->withDanger('Something wrong has happened');
        
    }
}
