<?php

namespace App\Http\Controllers;

use DB;
use App\Product;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('auth',['except'=>['index','show','search']]);
    }

    public function index()
    {
        $products = Product::orderBy('n_sold','desc')->get();

        //passing array of products in cart of this user to check if it the product is add or no
        $cart = CartController::checkAdded();
        $data = [
            'products' => $products,
            'cartp' => $cart,
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

        if(!Auth::guest() && Auth::user()->is_admin == 1)
        {
            return view('products.create');
        }
        else
        {
            return redirect('/products');
        }
        // redirect should be the url
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Auth::guest() && Auth::user()->is_admin == 1)
        {
            
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
            $product->owner_id = Auth::user()->id ;
            
            $product->profile_pic = $fileNameToStore;
            $product->save();
            return redirect('/products')->with('success', 'Product Added');

        }
        else
        {
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
        $data = [
            'product' => $product,
            'cartp' => $cart,
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
        
        if(!Auth::guest() && Auth::user()->is_admin == 1)
        {
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
            } //else {
            //     $fileNameToStore = 'noimage.jpg';
            // }

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
            $product->owner_id = Auth::user()->id ;

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
        $product= Product::find($id);
        if(auth()->user()->is_admin==1 || auth()->user()->id==$product->owner_id){ 
            if($product->profile_pic!='noimage.jpg'){
                Storage::delete('public/profile_pics/'.$product->profile_pic);
            }
            $product->delete();
            return redirect('/products')->with("success","Product was removed successfuly");
        }else{
            return redirect('/products')->with('error', "Authorization error");
        }
    }
    
    public function change_visibility($id){
        $product=Product::find($id);
        if($product->visible==1){
            $product->visible=0;
                $product->save();
            return redirect("/products")->with("success","The product is invisible NOW");
        }
        else{
            $product->visible=1;
            $product->save();
            return redirect("/products")->with("success","The product is visible NOW");
        }   
    }
    
    public function search(Request $request){
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
            $products=DB::select("SELECT DISTINCT * from products where LOWER(name) LIKE'$str2%' or LOWER(brand) LIKE'$str2%' or LOWER(category) LIKE'$str2%' order by n_sold desc");
        }else{
           $newstr= explode(" ", $str);
           for($i=0; $i<count($newstr); $i++){
            $newstr[$i] = "'".$newstr[$i]."'";
           }
           $words= implode(',', $newstr);
            $products=DB::select("SELECT DISTINCT * FROM products WHERE LOWER(name) in ($words) OR LOWER(brand) in ($words) OR LOWER(category) in ($words) order by n_sold desc");
            
        }
        $cart = CartController::checkAdded();
        $data = [
            'products' => $products,
            'cartp' => $cart,
        ];
         
        return view('products.index')->with($data);
    }
}
