<div class="single-product myPro">
    <div class="product-f-image">
        <img src="{{ asset('img/product-3.jpg') }}" alt="">
        {{-- Image will be replaced --}}
        <div class="product-hover">
            @guest
                {{-- do no thing --}}
            @else
                @if(Auth::user()->is_admin == '0')
                    <a href="#" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                    <a href="{{ url('products/' . $product->id) }}" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                @endif
            @endguest
        </div>
    </div>
    
    <h2><a href="#">{{ $product->name }}</a></h2>
    <div class="product-carousel-price">
        <ins>{{ $product->price }} $</ins>
        <span>{{ $product->brand }}</span>
    </div>

    <div class="admin-btns">
        {{-- Here will be a form to set invisible  --}}
        {{-- Here will be a form to remove product --}}
    </div>
</div>
