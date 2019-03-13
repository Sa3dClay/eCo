@extends('layouts.app')

@section('content')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Single Product</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="latest-product">
                
                @if( isset($product) )
                    <div class="col-md-2"></div>

                    <div class="col-md-4">
                        @include('inc.single-product')
                    </div>
                    
                    <div class="col-md-4">
                        <p>{{ $product->desc }}</p>
                    </div>

                    <div class="col-md-2"></div>
                @else
                    <p class="blank">No Product Found</p>
                @endif

            </div>
        </div>
    </div>

@endsection
