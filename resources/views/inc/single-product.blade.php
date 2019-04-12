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
                        <a href="{{ url('products/' . $product->id . '/edit') }}" class="add-to-cart-link"><i class="glyphicon glyphicon-wrench"></i> Update product</a>
                        {{-- Delete product --}}
                        <a href="" class="view-details-link" onclick="event.preventDefault(); document.getElementById('remove-submit').click();">
                            <i class="glyphicon glyphicon-remove"></i>Remove Product
                        </a>
                        {!! Form::open(['action' => ['ProductsController@destroy',$product->id],'method'=>'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::submit('Delete',['id'=>'remove-submit','style'=>'display:none'])}}
                        {!! Form::close() !!}
                    @endif
                @else
                    {{-- Unregistered user --}}
                    <a href="{{url('login')}}" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                    <a href="{{ url('products/' . $product->id) }}" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                @endif
            @else
                {{-- Customer --}}
                @if(Auth::user()->is_admin == 0)
                    {{-- Check Cart --}}
                    @if( isset($cartpros) && count($cartpros)>0 && in_array($product->id, $cartpros))
                        {{-- Here should be a button to remove from cart --}}
                        <a href="#" class="add-to-cart-link"><i class="fa fa-shopping-cart" ></i> Added to cart</a>
                    @else
                        {{-- Add to cart button --}} <?php //echo (isset($loop) ? 'add_to_cart'.$loop->iteration : 'add_to_cart') ?>
                        <a href="#" class="add-to-cart-link" onclick="event.preventDefault(); document.getElementById('<?php echo (isset($loop) ? 'add_to_cart'.$loop->iteration : 'add_to_cart') ?>').click();">
                            <i class="fa fa-shopping-cart"></i> Add to cart
                        </a>
                        {!! Form::open(['action' => 'CartController@store', 'method' => 'POST']) !!}
                            <input type="number" name="id" value="{{ $product->id }}" style="display:none" />
                            <button type="submit" style="display:none" id="<?php echo (isset($loop) ? 'add_to_cart'.$loop->iteration : 'add_to_cart') ?>">Add To Cart</button>
                            {{-- {{ Form::submit('Add to cart', ['id'=>'add_to_cart' . isset($loop) ? $loop->iteration, 'style'=>'display:none;']) }} --}}
                        {!! Form::close() !!}

                        {{-- {!! Form::open(['action' => ['CartController@store'], 'method'=>'POST']) !!}
                            <input type="number" name="id" value="{{ $product->id }}" style="display:none">
                            <a href="" class="add-to-cart-link" >
                                <i class="fa fa-shopping-cart"></i>{{ Form::submit('Add to cart',[]) }}
                            </a>
                        {!! Form::close() !!} --}}
                    @endif
                    {{-- Details --}}
                    <a href="{{ url('products/' . $product->id) }}" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                @endif
            @endguest
        </div>
    </div>
    {{-- Product Info --}}

    <?php // print_r($wishlistProducts)?>

    <table style="border-size:0;width:150% ">
        <tr>
            <td style=width:50% ><h2><a href="{{ url('products/' . $product->id) }}">{{ $product->name }}</a></h2></td>
            <td>
                    @if(!Auth::guest() && Auth::user()->is_admin == 0)
                    {{-- Customer --}}
                        {{-- Check wishlist --}}

                        @if( isset($wishlistProducts) && count($wishlistProducts)>0 && in_array($product->id, $wishlistProducts))
                            {{-- remove from wish list button --}}
                            <a title="Remove from wishlist" href="{{ url('wishlist/' . $product->id .'/remove_from_wishlist') }}">
                                <img src="img/remvefrom_wishlist.svg" alt="Add to wish list" height="30" width="30">
                            </a>
                        @else
                            {{-- Here should be a button to add to cart --}}
                            <a href="#" onclick="event.preventDefault(); document.getElementById('<?php echo (isset($loop) ? 'add_to_WL'.$loop->iteration : 'add_to_WL') ?>').click();">
                                <img src="img/addto_wishlist.svg" alt="Add to wish list" height="30" width="30">
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
                </div>
            </td>
            <td></td>
        </tr>
    </table>


    @guest
        <div class="admin-btns">
            @if (Auth::guard('admin')->check())
                @if (Auth::guard('admin')->user()->role == 'admin')
                    <a href="{{ route('change_visibilty',$product->id) }}" ><i class="glyphicon glyphicon-eye-close"></i> Set as Invisible</a>
                @endif
            @endif
        </div>
    @else
        <div class="admin-btns">
            @if(Auth::user()->is_admin == 1)
                <a href="{{ route('change_visibilty',$product->id) }}" ><i class="glyphicon glyphicon-eye-close"></i> Set as Invisible</a>
            @endif
        </div>
    @endguest
</div>
