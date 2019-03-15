@extends('layouts.app')

@section('content')

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Shop</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @include('inc.messages')
        <div class="row">
            <div class="latest-product">
                    
                @if( isset($products) && count($products) > 0 )
                    @foreach ($products as $product)
                        @if($product->visible==1)
                    
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

    <div class="product-pagination text-center">
        <nav>
            <ul class="pagination">
                <li>
                    <a href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>

                <li>
                    <a href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

@endsection
