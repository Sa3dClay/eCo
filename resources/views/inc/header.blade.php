<div class="header-area">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="user-menu">
                    <ul>
                        @guest
                            <li><a href="{{ route('login') }}"><i class="fa fa-user"></i> Login</a></li>
                            <li><a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Register</a></li>
                        @else
                            <li><a href="{{ url('/home') }}"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a></li>
                            <li><a href="#"><i class="fa fa-heart"></i> Wishlist</a></li>
                            <li><a href="{{ url('/cart') }}"><i class="fa fa-cart-plus"></i> My Cart</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Checkout</a></li>
                            
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Logout
                            </a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        @endguest    
                    </ul>
                </div>
            </div>
        </div><!-- End Of Row -->

    </div>
</div> <!-- End header area -->

<div class="site-branding-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="logo">
                    {{-- <h1><a href="{{ url('/') }}">e<span>Co</span></a></h1> --}}

                    <img src="{{ asset('img/eCo.png') }}" />
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="shopping-item">
                    <a href="#">Cart - <span class="cart-amunt">$800</span> <i class="fa fa-shopping-cart"></i> <span class="product-count">5</span></a>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End site branding area -->
