@extends('layouts.app')

@section('content')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                          <h2>Invisible products</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="latest-product">

                @if( isset($products) && count($products) > 0 )
                    @foreach ($products as $product)

                            <div class="col-lg-3 col-md-4 col-sm-6">
                                @include('inc.single-product')
                            </div>

                    @endforeach
                @else
                    <p class="blank">No Products Found</p>
                @endif

            </div>
        </div>
    </div>

@endsection
