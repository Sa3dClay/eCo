<?php
    $name = Route::currentRouteName();
    switch ($name) {
        case 'welcome':
            $home = true;
            break;
        case 'products.index':
            $shop = true;
            break;
        case 'reports.index':
            $repo = true;
            break;
        case 'cart.index':
            $cart = true;
            break;
        case 'invoice.create':
            $invo = true;
            break;
        case 'orders.index':
            $ord = true;
            break;
        default:
            // code
            break;
    }
?>

<div class="mainmenu-area">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="<?php if(isset($home)) echo 'active' ?>"><a href="{{ url('/') }}">Home</a></li>

                    <li class="<?php if(isset($shop)) echo 'active' ?>"><a href="{{ url('/products') }}">Shop</a></li>

                    @if(Auth::guard('admin')->check())
                        @if(Auth::guard('admin')->user()->role == 'admin')
                          <li class="<?php if(isset($ord)) echo 'active' ?>"><a href="{{url('invoice')}}">Orders</a></li>
                            <li class="<?php if(isset($repo)) echo 'active' ?>"><a href="{{url('reports')}}">Reports</a></li>
                        @endif

                        <li><a href="{{ route('get_my_products') }}">MY PRODUCTS</a></li>

                    @elseif( Auth::user() )
                        <li class="<?php if(isset($cart)) echo 'active' ?>"><a href="{{ url('cart') }}">Cart</a></li>

                        <li class="<?php if(isset($invo)) echo 'active' ?>"><a href="{{ url('/invoice/create') }}">Checkout</a></li>
                    @endif

                    @if(!Auth::guard('admin')->check())
                        <li><a href="#">About Us</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    @endif
                </ul>

                {!! Form::open(['action' => 'ProductsController@search','method'=>'POST','style'=>'padding-top:15px;margin-right=-15px; float:right;']) !!}
                    {{Form::text('text', '', ['class' => 'form-control', 'placeholder' => 'Search for products...'])}}
                    {{Form::submit('Search',['style'=>'display:none'])}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div> <!-- End mainmenu area -->
