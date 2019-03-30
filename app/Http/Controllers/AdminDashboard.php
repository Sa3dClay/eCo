<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Admin;
use App\User;

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
        $users = User::all();
        return view('dashboards.admin.users.show', compact('users'));
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
        $admin->role = $request->input('privilege');

        if($admin->save())
            return redirect('dashboard/admin/addmember')->withSuccess('Member has been added');
        else
            return redirect('dashboard/admin/addmember')->withDanger('Something wrong has happened');
        
    }

    public function blockUser(Request $request) {
        $user = User::find($request->input('user_id'));
        if($user->blocked){
            // user blocked and we need to unblock him
            $user->blocked = 0;
            $user->save();
            return redirect('dashboard/admin/users')->withSuccess('Unblocked user successfuly');
        } else {
            // we need to block the user
            $user->blocked = 1;
            $user->save();
            return redirect('dashboard/admin/users')->withSuccess('Blocked user successfuly ');
        }
    }
}
