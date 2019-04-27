<div class="single-product myPro">
    <div class="product-f-image">
        <img src="{{ asset( '/storage/profile_pics/' . $product->profile_pic ) }}" alt="product image" style="width:250px ;height:300px">
        {{-- Image will be replaced --}}
        <div class="product-hover">
            @guest
                {{-- Admin --}}
                @if (Auth::guard('admin')->check())
                    @if (Auth::guard('admin')->user()->role == 'admin')
                        {{-- Update product --}}
                        <a href="{{ url('products/' . $product->id . '/edit') }}" class="add-to-cart-link">
                            <i class="glyphicon glyphicon-wrench"></i> Update product
                        </a>
                        {{-- Delete product --}}
                        <a href="" class="view-details-link" onclick="event.preventDefault(); document.getElementById('<?php echo (isset($loop) ? 'remove_product'.$loop->iteration : 'remove_product') ?>').click();">
                            <i class="glyphicon glyphicon-remove"></i> Remove Product
                        </a>
                        {!! Form::open(['action' => ['ProductsController@destroy', $product->id], 'method'=>'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            <button type="submit" style="display:none" id="<?php echo (isset($loop) ? 'remove_product'.$loop->iteration : 'remove_product') ?>">Remove Product</button>
                        {!! Form::close() !!}
                    {{-- Seller --}}
                    @else
                        {{-- Update product --}}
                        <a href="{{ url('products/' . $product->id . '/edit') }}" class="add-to-cart-link">
                            <i class="glyphicon glyphicon-wrench"></i> Update product
                        </a>
                        @if(Route::currentRouteName() == "get_my_products")
                            <a href="" class="view-details-link" onclick="event.preventDefault(); document.getElementById('<?php echo (isset($loop) ? 'remove_product'.$loop->iteration : 'remove_product') ?>').click();">
                                <i class="glyphicon glyphicon-remove"></i> Remove Product
                            </a>
                        @else
                            {{-- Details --}}
                            <a href="{{ url('products/' . $product->id) }}" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                        @endif
                    @endif
                @else
                    {{-- Unregistered user --}}
                    <a href="{{ url('login') }}" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                    <a href="{{ url('products/' . $product->id) }}" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                @endif
            @else
            {{-- Customer --}}

                {{-- Check Cart --}}
                @if( isset($cartpros) && count($cartpros)>0 && in_array($product->id, $cartpros))
                    {{-- Here should be a button to remove from cart --}}
                    <a href="{{ url('cart/' . $product->id . '/remove_from_cart') }}" class="add-to-cart-link">
                        <i class="glyphicon glyphicon-remove" ></i> From Cart
                    </a>
                @else
                    {{-- Add to cart button --}} <?php //echo (isset($loop) ? 'add_to_cart'.$loop->iteration : 'add_to_cart') ?>
                    <a href="#" class="add-to-cart-link" onclick="event.preventDefault(); document.getElementById('<?php echo (isset($loop) ? 'add_to_cart'.$loop->iteration : 'add_to_cart') ?>').click();">
                        <i class="fa fa-shopping-cart"></i> Add to cart
                    </a>
                    {!! Form::open(['action' => 'CartController@store', 'method' => 'POST']) !!}
                        <input type="number" name="id" value="{{ $product->id }}" style="display:none" />
                        <button type="submit" style="display:none" id="<?php echo (isset($loop) ? 'add_to_cart'.$loop->iteration : 'add_to_cart') ?>">Add To Cart</button>
                    {!! Form::close() !!}
                @endif
                {{-- Details --}}
                <a href="{{ url('products/' . $product->id) }}" class="view-details-link"><i class="fa fa-link"></i> See details</a>
            @endguest
        </div>
    </div>
    {{-- Product Info --}}

    <?php // print_r($wishlistProducts)?>

    <table style="border-size: 0; width: 150%;">
        <tr>
            <td style="width: 50%;"><h2><a href="{{ url('products/' . $product->id) }}">{{ $product->name }}</a></h2></td>
            <td>
                @if( !Auth::guest() )
                {{-- Customer --}}

                    {{-- Check wishlist --}}
                    @if( isset($wishlistProducts) && count($wishlistProducts)>0 && in_array($product->id, $wishlistProducts) )
                        {{-- remove from wish list button --}}
                        <a title="Remove from wishlist" href="{{ url('wishlist/' . $product->id .'/remove_from_wishlist') }}">
                            <img src="{{ asset('img/remvefrom_wishlist.svg') }}" alt="remove from wish list" height="30" width="30">
                        </a>
                    @else
                        {{-- Here should be a button to add to wish list --}}
                        <a href="#" onclick="event.preventDefault(); document.getElementById('<?php echo (isset($loop) ? 'add_to_WL'.$loop->iteration : 'add_to_WL') ?>').click();">
                            <img src="{{ asset('img/addto_wishlist.svg') }}" alt="Add to wish list" height="30" width="30">
                        </a>
                        {!! Form::open(['action' => 'wish_listController@store', 'method' => 'POST']) !!}
                            <input type="number" name="id" value="{{ $product->id }}" style="display:none" />
                            <button type="submit" style="display:none" id="<?php echo (isset($loop) ? 'add_to_WL'.$loop->iteration : 'add_to_WL') ?>">Add To wishlist</button>
                        {!! Form::close() !!}
                    @endif
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <div class="product-carousel-price">
                    <ins>${{ $product->price }}</ins>
                    <span>{{ $product->brand }}</span>
                    @if (Auth::guard('admin')->check())
                        @if (Auth::guard('admin')->user()->role == 'admin')
                            <!--<span><b>created by</b> {//{$product->owner_id }}</span> -->
                        @endif
                    @endif
                </div>
            </td>
            <td></td>
        </tr>
    </table>

    @guest
    {{-- Admin btns --}}
        <div class="admin-btns">
            @if (Auth::guard('admin')->check())
                @if (Auth::guard('admin')->user()->role == 'admin')

                    @if($product->visible == 1)
                        <a href="{{ route('change_visibilty', $product->id) }}" ><i class="glyphicon glyphicon-eye-close"></i> Set as Invisible</a>
                    @else
                        <a href="{{ route('change_visibilty', $product->id) }}" ><i class="glyphicon glyphicon-eye-open"></i> Set as Visible</a>
                    @endif

                @endif
            @endif
        </div>
    @endguest
</div>
{!! Form::open(['action' => ['ProductsController@destroy',$product->id],'method'=>'POST']) !!}
    {{Form::hidden('_method','DELETE')}}
    {{Form::submit('Delete',['id'=>'remove-submit','style'=>'display:none'])}}
{!! Form::close() !!}
