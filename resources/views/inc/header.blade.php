<div class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-menu">
                    <ul>
                        @guest
                            @if (Auth::guard('admin')->check())
                                <li><a href="{{ url('admin/register') }}"><i class="fa fa-user-plus"></i> add admin</a></li>
                                <li><a href="{{ url('seller/register') }}"><i class="fa fa-user-plus"></i> add seller</a></li>
                                <li><a href="{{ url('admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a></li>
                                <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                @if (Auth::guard('seller')->check())
                                    <li><a href="{{ url('seller/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i> Logout
                                    </a></li>
                                    <form id="logout-form" action="{{ url('seller/logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <li><a href="{{ Request::is('admin/login') ? url('admin/login') : Request::is('seller/login') ? url('seller/login') : url('login') }}"><i class="fa fa-user"></i> Login</a></li>
                                    @if (!Request::is('admin/login') && !Request::is('seller/login'))
                                        <li><a href="{{ url('register') }}"><i class="fa fa-user-plus"></i> Register</a></li>
                                    @endif
                                @endif
                            @endif
                        @else
                            <li><a href="{{ url('/home') }}"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a></li>
                            @if(Auth::user()->is_admin==0)
                                <li><a href="#"><i class="fa fa-heart"></i> Wishlist</a></li>
                                <li><a href="{{ url('/cart') }}"><i class="fa fa-cart-plus"></i> My Cart</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Checkout</a></li>
                            @else
                                 <li><a href="#"><i class="glyphicon glyphicon-search"></i> User Search</a></li>
                                 <li><a href="#"><i class="glyphicon glyphicon-eye-close"></i> Invisible products</a></li> 
                                 <li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> View reports</a></li>
                            @endif         
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                <div class="shopping-item">
                    <a href="#">Cart - <span class="cart-amunt">$800</span> <i class="fa fa-shopping-cart"></i> <span class="product-count">5</span></a>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End site branding area -->