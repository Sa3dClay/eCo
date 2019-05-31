<?php

namespace App\Http\Controllers;

use DB;
use App\Product;
use App\Cart;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CartController;
use App\Http\Controllers\wish_listController;
use App\Http\Controllers\NotificationController;

use App\Traits\Notifications;


class ProductsController extends Controller
{

    use Notifications;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('admin',['only'=>['destroy','change_visibility','edit','create']]);
    }

    public function index()
    {
        $products = Product::orderBy('n_sold','desc')->get();

        //passing array of products in cart of this user to check if it the product is add or no
        $cart = CartController::checkAdded();
        $wl = wish_listController::checkAdded();
        $countNew = NotificationController::checkAdded();
        $data = [
            'products' => $products,
            'cartpros' => $cart,
            'wishlistProducts' => $wl,
            'countNew' => $countNew
        ];

        return view('products.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countNew = NotificationController::checkAdded();
        return view('products.create')->with('countNew',$countNew);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //untill we remove is_admin,we'are checking for it
    {
        if( !Auth::guest() && Auth::user()->is_admin == 1 || Auth::guard('admin')->check() ){
            $this->validate($request, [
                'name' => 'required',
                'price' => 'required',
                'brand' => 'required',
                'quantity' => 'required',
                'category' => 'required',
                'desc' => 'required',
                'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            // Handle File Upload
            if($request->hasFile('profile_pic')){
                // Get filename with the extension
                $filenameWithExt = $request->file('profile_pic')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('profile_pic')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                // Upload Image
                $path = $request->file('profile_pic')->storeAs('public/profile_pics', $fileNameToStore);
            } else {
                $fileNameToStore = 'noimage.jpg';
            }
            // Create Product
            /* the commentet statment should be used for testing */

            $product = new Product;
            $product->name = $request->input('name');

            $product->price = $request->input('price');
            // $product->price = 1;

            $product->brand = $request->input('brand');

            $product->quantity = $request->input('quantity');
            // $product->quantity = 1;

            $product->category = $request->input('category');
            $product->desc = $request->input('desc');

            // $product->owner_id = 1;
            if(Auth::user()!=null){ //it will case redundant id(s)
                $product->owner_id = Auth::user()->id ;
            }else{
                $product->owner_id=Auth::guard('admin')->user()->id;
            }
            $product->profile_pic = $fileNameToStore;
            $product->save();

            $seller = Admin::find(Auth::guard('admin')->user()->id);

            $this->newProduct($seller->id, $product->name , "seller");
            // to add which admin you need to send this notification to?
            $this->sellerProduct(1, $seller->name , $product->name , "seller");

            return redirect('/products')->with('success', 'Product Added');
        } else {
            return redirect('/products')->with('error', 'You are not authorized to add product');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        //passing array of products in cart of this user to check if it the product is add or no
        $cart = CartController::checkAdded();
        $wl = wish_listController::checkAdded();
        $countNew = NotificationController::checkAdded();
        $data = [
            'product' => $product,
            'cartpros' => $cart,
            'wishlistProducts' => $wl,
            'countNew' => $countNew
        ];

        return view('products.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get product with id to view there data
        $product = Product::find($id);
        return view('products.edit')->with('product', $product);
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

        if( !Auth::guest() && Auth::user()->is_admin == 1 || Auth::guard('admin')->check() ){
            //Validation on submited Data
            $this->validate($request, [
                'name' => 'required',
                'price' => 'required',
                'brand' => 'required',
                'quantity' => 'required',
                'category' => 'required',
                'desc' => 'required',
                //'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            // Handle File Upload
            if($request->hasFile('profile_pic')){
                // Get filename with the extension
                $filenameWithExt = $request->file('profile_pic')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('profile_pic')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                // Upload Image
                $path = $request->file('profile_pic')->storeAs('public/profile_pics', $fileNameToStore);
            }

            // Update Product
            /* the commentet statment should be used for testing */
            $product = Product::find($id);
            $product->name = $request->input('name');

            $product->price = $request->input('price');
            // $product->price = 1;

            $product->brand = $request->input('brand');

            $product->quantity = $request->input('quantity');
            // $product->quantity = 1;

            $product->category = $request->input('category');
            $product->desc = $request->input('desc');

            // $product->owner_id = 1;
            if(Auth::user()!=null){ //it will case redundant id(s)
                $product->owner_id = Auth::user()->id ;
            }else{
                $product->owner_id=Auth::guard('admin')->user()->id;
            }

            if($request->hasFile('profile_pic')){
                $product->profile_pic = $fileNameToStore;
            }

            $product->save();
            return redirect('/products')->with('success', 'Product Updated Successfully');

        }
        else
        {
            return redirect('/products')->with('success', 'You are not authorized to update product');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if( Auth::guard('admin')->check() || Auth::user() ) {
            if($product->profile_pic != 'noimage.jpg') {
                Storage::delete('public/profile_pics/'.$product->profile_pic);
            }

            $cart = new CartController;
            $wl = new wish_listController;
            $cart->remove_from_all_carts($id);
            $wl->remove_from_all_wishLists($id);

            if( $product->delete() ) {
                return redirect('/products')->with("success", "Product was removed successfuly");
            } else {
                return redirect('/products')->with("error", "Error with last action");
            }

        } else {
            return redirect('/products')->with("error", "Authorization error");
        }
    }

    // Update product quantity
    public function update_qunatity($id, $qnt) {
        $product = Product::find($id);

        $product->quantity = $product->quantity - $qnt;

        if($product->quantity <= 0) {
            $this->destroy($product->id);
        } else {
            $product->save();
        }
    }

    // Update number of sold product
    public function update_nSold($id, $qnt) {
        $product = Product::find($id);

        $product->n_sold = $product->n_sold + $qnt;

        $product->save();
    }

    // Change visibility of any product by admin
    public function change_visibility($id){
        $product = Product::find($id);

        if($product->visible == 1) {

            $product->visible = 0;
            $product->save();

            return redirect("/products")->with("success","The product is invisible NOW");

        } else {

            $product->visible = 1;
            $product->save();

            return redirect("/products")->with("success","The product is visible NOW");

        }
    }

    // Search for products
    public function search(Request $request) {
        $strword=$request->input('text');
        if(strlen($strword)==0){
            return $this->index();
        }
        $str = strtolower($strword);
        $chars = str_split($str);
        $str2 = '';
        $n = strpos($str, ' ');
        if(!is_numeric($n)) {
            $str2 = implode($str2, $chars);
            $products=Product::find_no_space($str2);
        } else {
            $newstr= explode(" ", $str);
            for($i=0; $i<count($newstr); $i++){
                $newstr[$i] = "'".$newstr[$i]."'";
            }
            $words= implode(',', $newstr);
            $products= Product::find_space($words);
        }
        $cart = CartController::checkAdded();
        $wl = wish_listController::checkAdded();
        $countNew = NotificationController::checkAdded();
        $data = [
            'products' => $products,
            'cartpros' => $cart,
            'wishlistProducts' => $wl,
            'countNew' => $countNew
        ];

        return view('products.index')->with($data);
    }

    public function get_my_products(){
        $products = Product::where('owner_id',Auth::guard('admin')->user()->id)->orderBy('created_at','desc')->get();

        $countNew = NotificationController::checkAdded();
        $data = [
            'products' => $products,
            'countNew' => $countNew
        ];
        return $data;
    }

    public function get_invisible(){
        $products = Product::where('visible', '0')->get();

        $countNew = NotificationController::checkAdded();
        $data = [
            'products' => $products,
            'countNew' => $countNew
        ];
        return $data;
    }
}
