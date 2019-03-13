<?php
    $name = Route::currentRouteName();

    switch ($name) {
        case 'welcome':
            $home = true;
            break;
        case 'products.index':
            $shop = true;
            break;
        case 'cart.index':
            $cart = true;
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
                    <li class="<?php if(isset($cart)) echo 'active' ?>"><a href="{{ url('/cart') }}">Cart</a></li>
                    <li><a href="#">Checkout</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>  
        </div>
    </div>
</div> <!-- End mainmenu area -->
