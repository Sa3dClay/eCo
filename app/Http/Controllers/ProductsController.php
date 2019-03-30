<?php

namespace App\Http\Controllers;

use DB;
use App\Product;
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
        $this->middleware('auth',['except'=>['index','show']]);
    }
   
    public function index()
    {
        $products = Product::orderBy('n_sold','desc')->get();
        return view('products.index')->with('products', $products);
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
            return redirect('/products')->with('success', 'You are not authorized to add product');
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
        
        return view('products.show')->with('product', $product);
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
    
    public function search($strword){
        if(strlen($strword)==0){
            return $this->index();
        }
        // $db = $this->get_db();
        $str = strtolower($strword);
        $chars = str_split($str);
        $str2 = '';
        //$idarr = array();
        $n = strpos($str, ' ');
        if(!is_numeric($n)) {
            $str2 = implode($str2, $chars);
            $products=DB::select("SELECT distinct from product where LOWER(name) LIKE'$str2%' or LOWER(brand) LIKE'$str2%' or LOWER(category) LIKE'$str2%' order by n_sold");
        }else{
           $newstr= explode(" ", $str);
           for($i=0; $i<count($newstr); $i++){
            $word = $newstr[$i];
            $products+=DB::select("SELECT distinct FROM product WHERE LOWER(name) = '$word' OR LOWER(brand) = '$word' OR LOWER(category) ='$word'");
            }
        }
        return redirect("/products")->with("product",array_unique($products));
    }
}
