@extends('layouts.app')

@section('content')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                          <h2>Wish List</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="latest-product">

                @if( isset($wl_products) && count($wl_products) > 0 )
                    @foreach ($wl_products as $product)
                        @if($product->visible == 1)

                            <div class="col-lg-3 col-md-4 col-sm-6">
                                @include('inc.single-product')
                            </div>

                        @endif
                    @endforeach
                @else
                    <p class="blank">No Products Found</p>
                @endif

            </div>
        </div>
    </div>

@endsection
