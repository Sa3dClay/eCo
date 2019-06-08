@extends('layouts.app')

@section('content')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Shopping Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->

    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">

                <div class="col-md-4">
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Recent products</h2>

                        @if( isset($products) && count($products) > 0 )
                            <ul>
                                @foreach ($products as $product)
                                    <li><a href="{{ url('products/' . $product->id) }}">{{ $product->name }}</a></li>
                                @endforeach
                            </ul>
                        @else
                            <p class="blank">No Products Found</p>
                        @endif

                    </div>
                </div>

                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="woocommerce">

                            <table cellspacing="0" class="shop_table cart">
                                <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Cost</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {{-- Here will be the dynamic view of products --}}

                                    @if( isset($products) && count($products) > 0 )
                                        @foreach ($products as $product)

                                            <tr class="cart_item">
                                                {{-- Here you can remove product when you click the button --}}
                                                <td class="product-remove">
                                                    {{-- {!! Form::open(['action' => ['CartController@remove_from_cart',$product->id],'method'=>'POST']) !!}
                                                        {{Form::hidden('_method','DELETE')}}
                                                        {{Form::submit('Delete',['id'=>'remove-item','style'=>'display:none'])}}
                                                    {!! Form::close() !!} --}}
                                                    <a title="Remove this item" class="remove" href="{{ url('cart/' . $product->id .'/remove_from_cart') }}">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </a>
                                                </td>

                                                <td class="product-thumbnail">
                                                    <a href="{{ url('products/' . $product->id) }}"><img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="{{ asset( '/storage/profile_pics/' . $product->profile_pic ) }}"></a>
                                                </td>

                                                <td class="product-name">
                                                    <a href="{{ url('products/' . $product->id) }}">{{ $product->name }}</a>
                                                </td>

                                                <td class="product-price">
                                                    <span class="amount">${{ $product->price }}</span>
                                                </td>

                                                {!! Form::open(['action' => ['CartController@update',$product->id],'method'=>'PUT']) !!}
                                                <td class="product-quantity">
                                                    <div class="quantity buttons_added">

                                                        <input type="number" size="4" name="qty" class="input-text qty text" title="Qty" value="{{ $product->n_of_pro }}" min="1" max="{{ $product->quantity }}" step="1">

                                                        {{-- <input href="" type="submit"  value="Update Cart" class="button"> --}}
                                                        {{Form::hidden('_method','PUT')}}
                                                        {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
                                                    </div>
                                                </td>
                                                {!! Form::close() !!}

                                                <td class="product-subtotal">
                                                    {{-- Here will be the total price --}}
                                                    <span class="amount">${{ $product->price }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p class="blank">No Products Found</p>
                                    @endif

                                    {{-- End of dynamic view --}}
                                </tbody>
                            </table>

                            <div class="cart-collaterals">

                                {{-- <div class="cross-sells">
                                    <h2>You may be interested in...</h2>
                                    <ul class="products">
                                        <li class="product">
                                            <a href="#">
                                                <img width="325" height="325" alt="T_4_front" class="attachment-shop_catalog wp-post-image" src="img/product-2.jpg">
                                                <h3>Ship Your Idea</h3>
                                                <span class="price"><span class="amount">£20.00</span></span>
                                            </a>

                                            <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="22" rel="nofollow" href="#">Select options</a>
                                        </li>

                                        <li class="product">
                                            <a href="#">
                                                <img width="325" height="325" alt="T_4_front" class="attachment-shop_catalog wp-post-image" src="img/product-4.jpg">
                                                <h3>Ship Your Idea</h3>
                                                <span class="price"><span class="amount">£20.00</span></span>
                                            </a>

                                            <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="22" rel="nofollow" href="#">Select options</a>
                                        </li>
                                    </ul>
                                </div> --}}

                                @if( isset($products) && count($products) > 0 && isset($totalCost) )

                                    <div class="cart_totals ">
                                        <h2>Cart Totals</h2>

                                        <table cellspacing="0">
                                            <tbody>
                                                <tr class="cart-subtotal">
                                                    <th>Cart Subtotal</th>
                                                    <td><span class="amount">${{ $totalCost }}</span></td>
                                                </tr>

                                                <tr class="shipping">
                                                    <th>Shipping and Handling</th>
                                                    <td>%5</td>
                                                </tr>

                                                <tr class="order-total">
                                                    <th>Order Total</th>
                                                    <!-- %15 for shipping -->
                                                    <td><strong><span class="amount">${{ $totalCost+(0.05*$totalCost) }}</span></strong> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                @endif

                                {{-- <form method="post" action="#" class="shipping_calculator">
                                    <h2><a class="shipping-calculator-button" data-toggle="collapse" href="#" aria-expanded="false" aria-controls="calcalute-shipping-wrap">Calculate Shipping</a></h2>

                                    <section id="calcalute-shipping-wrap" class="shipping-calculator-form collapse">

                                    <p class="form-row form-row-wide">

                                    </p>

                                    <p class="form-row form-row-wide"><input type="text" id="calc_shipping_state" name="calc_shipping_state" placeholder="State / county" value="" class="input-text"> </p>

                                    <p class="form-row form-row-wide"><input type="text" id="calc_shipping_postcode" name="calc_shipping_postcode" placeholder="Postcode / Zip" value="" class="input-text"></p>

                                    <p><button class="button" value="1" name="calc_shipping" type="submit">Update Totals</button></p>

                                    </section>
                                </form> --}}



                                <a href="{{ url('/invoice/create') }}" ><button type="button" class="btn btn-success" >Check Out</button></a>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
