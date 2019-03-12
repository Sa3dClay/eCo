<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Product;
use DB;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index');
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
                'profile_pic' => 'image|nullable|max:1999'
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
            // Create Post

            
            
            $product = new Product;
            $product->name = $request->input('name');

            $product->price = $request->input('price');
        // $product->price = 1;

            $product->brand = $request->input('brand');
            
            $product->quantity = $request->input('quantity');
        // $product->quantity = 1;

            $product->category = $request->input('category');
            $product->desc = $request->input('desc');

            /* the commentet statment should be used for testing */
        // $product->owner_id = 1;
            $product->owner_id = Auth::user()->id ;
            
            $product->profile_pic = $fileNameToStore;
            $product->save();
            return redirect('/products')/*->with('success', 'Product Added')*/;



        }
        else
        {
            return redirect('/products')/*->with('success', 'You are not authorized to add product')*/;
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
}