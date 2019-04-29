<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Admin;
use App\User;
//use App\product;

use App\Traits\Notifications;

class AdminDashboard extends Controller
{
    private $product;
    use Notifications;

    public function __construct()
    {
        $this->product=new ProductsController;
        $this->middleware('admin');
    }

    public function index()
    {
       $countNew = NotificationController::checkAdded();
        return view('dashboards.admin.index')->with($countNew);
    }

    public function showRegister() {
        return view('dashboards.auth.register');
    }

    public function showUsers() {
        $users = User::all();
        $admins = Admin::all();
        $data = [
            'users' => $users,
            'admins' => $admins
        ];
        return view('dashboards.admin.users.show')->with($data);
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

        if($admin->save()){
            $this->createSeller(Auth::guard("admin")->user()->id, "seller");
            return redirect('dashboard/admin/addmember')->withSuccess('Member has been added');
        }
        else
            return redirect('dashboard/admin/addmember')->withDanger('Something wrong has happened');

    }

    public function blockUser(Request $request) {
        $user = User::find($request->input('user_id'));
        if($user->blocked){
            // user blocked and we need to unblock him
            $user->blocked = 0;
            $user->save();
            $this->userToUnblock($user->id, "normal");
            return redirect('dashboard/admin/users')->withSuccess('Unblocked user successfully');
        } else {
            // we need to block the user
            $user->blocked = 1;
            $user->save();
            $this->userToBlock($user->id, "normal");
            return redirect('dashboard/admin/users')->withSuccess('Blocked user successfully ');
        }
    }

    public function blockSeller(Request $request) {
        $admin = Admin::find($request->input('user_id'));
        if($admin->blocked){
            // seller blocked and we need to unblock him
            $admin->blocked = 0;
            $admin->save();
            return redirect('dashboard/admin/users')->withSuccess('Unblocked Seller successfully');
        } else {
            // we need to block the seller
            $admin->blocked = 1;
            $admin->save();
            return redirect('dashboard/admin/users')->withSuccess('Blocked Seller successfully ');
        }
    }

    public function deleteUser(Request $request) {
        $user = User::find($request->input('user_id'));

        if($user->delete())
            return redirect('dashboard/admin/users')->withSuccess('User has been deleted');
        else
            return redirect('dashboard/admin/users')->withDanger('Something wrong has happened');
    }

    public function deleteSeller(Request $request) {
        $seller = Admin::find($request->input('user_id'));

        if($seller->delete())
            return redirect('dashboard/admin/users')->withSuccess('Seller has been deleted');
        else
            return redirect('dashboard/admin/users')->withDanger('Something wrong has happened');
    }

    public function get_invisible(){
      $data=$this->product->get_invisible();
      return view('products.invisible')->with($data);
    }

    public function get_my_products(){
      $data=$this->product->get_my_products();
      return view('products.my_products')->with($data);
    }
}
