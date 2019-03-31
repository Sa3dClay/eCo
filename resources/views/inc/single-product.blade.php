<div class="single-product myPro">
    <div class="product-f-image">
        <img src="{{ asset( '/storage/profile_pics/' . $product->profile_pic ) }}" alt="product image" style="width:250px ;height:300px">
        {{-- Image will be replaced --}}
        <div class="product-hover">
            @guest
                <a href="{{url('login')}}" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                <a href="{{ url('products/' . $product->id) }}" class="view-details-link"><i class="fa fa-link"></i> See details</a>
            @else
                @if(Auth::user()->is_admin == 0) 
                    
                    <?php  //print_r($product->id) . '<br>' . print_r($cartp); ?> 
                        
                        @if(count($cartp)>0 && in_array($product->id,$cartp))
                            <a href="#" class="add-to-cart-link"><i class="fa fa-shopping-cart" ></i> Added to cart</a>
                        @else
                            <!--<a href="" class="add-to-cart-link"  onclick="event.preventDefault(); document.getElementById('add_to_cart').click();" >
                                 <i class="fa fa-shopping-cart">Add to cart</i>
                            </a>
                            /*{!! Form::open(['action' => ['CartController@store'],'method'=>'POST']) !!}
                                <input name="id" value="{{ $product->id }}" style="display:none">
                                {{-- Form::number('id',$product->id,['style'=>'display:none']) --}}
                                {{ Form::submit('Add to cart',['id'=>'add_to_cart','style'=>'display:none;']) }}     
                            {!! Form::close() !!}*/-->
                              {!! Form::open(['action' => ['CartController@store'],'method'=>'POST']) !!}
                                <input name="id" value="{{ $product->id }}" style="display:none">
                                {{-- Form::number('id',$product->id,['style'=>'display:none']) --}}
                                <a href="" class="add-to-cart-link" >
                                    <i class="fa fa-shopping-cart"></i>{{ Form::submit('Add to cart',[]) }}
                                </a>
                            {!! Form::close() !!}
                            <!--<a href="" class="add-to-cart-link" onclick="event.preventDefault(); document.getElementById('add_to_cart').click();">
                            <i class="fa fa-shopping-cart"></i>Add to cart</a>-->
                        @endif
                        
                    <!--<a href="#" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add to cart</a>-->
                    <a href="{{ url('products/' . $product->id) }}" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                @else 
                    <a href="{{ url('products/' . $product->id . '/edit') }}" class="add-to-cart-link"><i class="glyphicon glyphicon-wrench"></i> Update product</a>
                    
                    <a href="" class="view-details-link" onclick="event.preventDefault(); document.getElementById('remove-submit').click();">
                        <i class="glyphicon glyphicon-remove"></i>Remove Product
                    </a>
                    {!! Form::open(['action' => ['ProductsController@destroy',$product->id],'method'=>'POST']) !!}
                        {{Form::hidden('_method','DELETE')}}
                        {{Form::submit('Delete',['id'=>'remove-submit','style'=>'display:none'])}}
                    {!! Form::close() !!}
               @endif 
            @endguest
        </div>
    </div>
    
    <h2><a href="{{ url('products/' . $product->id) }}">{{ $product->name }}</a></h2>
    <div class="product-carousel-price">
        <ins>${{ $product->price }}</ins>
        <span>{{ $product->brand }}</span>
    </div>
    @guest
        {{-- do no thing --}}
    @else
        <div class="admin-btns">
            @if(Auth::user()->is_admin == 1)    
                <a href="{{ route('change_visibilty',$product->id) }}" ><i class="glyphicon glyphicon-eye-close"></i> Set as Invisible</a>
            @endif 
        </div>
    @endguest              
</div>
