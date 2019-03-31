<div class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-menu">
                    <ul>
                        @guest
                            @if (Auth::guard('admin')->check())
                                @if (Auth::guard('admin')->user()->role == 'seller')
                                    <li><a href="{{ url('dashboard/seller/addproducts') }}"><i class="fa fa-plus"></i> add products</a></li>
                                    <li><a href="{{ url('dashboard/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i> Logout
                                    </a></li>
                                    <form id="logout-form" action="{{ url('dashboard/logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <li><a href="{{ url('dashboard/admin/addmember') }}"><i class="fa fa-user-plus"></i> add member</a></li>
                                    <li><a href="{{ url('dashboard/admin/users') }}"><i class="glyphicon glyphicon-search"></i> User Search</a></li>
                                    <li><a href="#"><i class="glyphicon glyphicon-eye-close"></i> Invisible products</a></li> 
                                    <li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> View reports</a></li>
                                    <li><a href="{{ url('dashboard/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i> Logout
                                    </a></li>
                                    <form id="logout-form" action="{{ url('dashboard/logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @endif
                            @else
                                <li><a href="{{ Request::is('dashboard/login') ? url('dashboard/login') : url('login') }}"><i class="fa fa-user"></i> Login</a></li>
                                @if (!Request::is('dashboard/login'))
                                    <li><a href="{{ url('register') }}"><i class="fa fa-user-plus"></i> Register</a></li>
                                @endif
                            @endif
                        @else
                            <li><a href="{{ url('/home') }}"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a></li>
                            <li><a href="#"><i class="fa fa-heart"></i> Wishlist</a></li>
                            <li><a href="{{ url('/cart') }}"><i class="fa fa-cart-plus"></i> My Cart</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Checkout</a></li>
                            <li><a href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Logout
                            </a></li>
                            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
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

                    <a href="{{ route('welcome') }}"> <img src="{{ asset('img/eCo.png') }}" /> </a>
                </div>
            </div>
            
            <div class="col-sm-6">
                @if( isset( Auth::user()->id ) && Auth::user()->is_admin = 0 )
                    <div class="shopping-item">
                        <a href="{{route('cart.index')}}">Cart <!-- - <span class="cart-amunt">$800</span> --> <i class="fa fa-shopping-cart"></i> <!-- <span class="product-count">5</span> --> </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div> <!-- End site branding area -->
