<div class="header-area">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="user-menu">
                    <ul>
                        @guest
                            {{-- Admin and Seller --}}
                            @if (Auth::guard('admin')->check())
                                {{-- Seller --}}
                                @if (Auth::guard('admin')->user()->role == 'seller')
                                    <li><a href="{{ url('products/create') }}"><i class="fa fa-plus"></i> add products</a></li>
                                {{-- Admin --}}
                                @elseif (Auth::guard('admin')->user()->role == 'admin')
                                    <li><a href="{{ url('dashboard/admin/addmember') }}"><i class="fa fa-user-plus"></i> add member</a></li>
                                    <li><a href="{{ url('dashboard/admin/users') }}"><i class="glyphicon glyphicon-search"></i> User Search</a></li>
                                    <li><a href="{{ url('dashboard/admin/get_invisible') }}"><i class="glyphicon glyphicon-eye-close"></i> Invisible products</a></li>
                                    <li><a href="{{ url('reports') }}"><i class="glyphicon glyphicon-chevron-right"></i> View reports</a></li>
                                @endif
                                {{-- Logout for Admin and Seller --}}
                                <li><a href="{{ url('dashboard/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a></li>
                                <form id="logout-form" action="{{ url('dashboard/logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="{{ url('notifications') }}" style="float:right;margin-top:10px"><i class="glyphicon glyphicon-bell"></i> Notifications</a>
                            @else
                                {{-- Redirecting to login page --}}
                                <li><a href="{{ Request::is('dashboard/login') ? url('dashboard/login') : url('login') }}"><i class="fa fa-user"></i> Login</a></li>
                                @if (!Request::is('dashboard/login'))
                                    <li><a href="{{ url('register') }}"><i class="fa fa-user-plus"></i> Register</a></li>
                                @endif
                            @endif
                        @else
                            {{-- Customer --}}
                            <li><a href="{{ url('/home') }}"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a></li>
                            <li><a href="{{ url('/cart') }}"><i class="fa fa-cart-plus"></i> My Cart</a></li>
                            <li><a href="{{ url('/wishlist') }}"><i class="fa fa-heart"></i> Wishlist</a></li>
                            <li><a href="{{ url('/invoice/create') }}"><i class="fa fa-check"></i> Checkout</a></li>
                            {{-- Logout --}}
                            <li><a href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Logout
                            </a></li>
                            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="{{ url('notifications') }}" style="float:right;margin-top:10px"><i class="glyphicon glyphicon-bell"></i> Notifications</a>
                        @endguest
                    </ul>
                </div>
            </div>

        </div><!-- End Of Row -->
    </div><!-- End of container -->
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
                @if( isset( Auth::user()->id ) && Auth::user()->is_admin == '0' )
                    <div class="shopping-item">
                        <a href="{{route('cart.index')}}">Cart
                            <!-- - <span class="cart-amunt">$800</span> -->
                            <i class="fa fa-shopping-cart"></i>
                            @if( isset($cartpros) && count($cartpros)>0 )
                                <span class="product-count">{{ count($cartpros) }}</span>
                            @endif
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div> <!-- End site branding area -->
