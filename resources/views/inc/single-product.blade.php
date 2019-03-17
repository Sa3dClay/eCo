<div class="single-product myPro">
    <div class="product-f-image">
        <img src="{{ asset( '/storage/profile_pics/' . $product->profile_pic ) }}" alt="product image" style="width:250px ;height:300px">
        {{-- Image will be replaced --}}
        <div class="product-hover">
            @guest
                {{-- do no thing --}}
            @else
               @if(Auth::user()->is_admin == 0) 
                    <a href="#" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                    <a href="{{ url('products/' . $product->id) }}" class="view-details-link"><i class="fa fa-link"></i> See details</a>
               @else 
                    <a href="#" class="add-to-cart-link"><i class="glyphicon glyphicon-wrench"></i> Update product</a>
                    
                    <a href="" class="view-details-link" onclick="event.preventDefault(); document.getElementById('remove-submit').click();">
                        <i class="glyphicon glyphicon-remove"></i>Remove Product</a>
                        
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
