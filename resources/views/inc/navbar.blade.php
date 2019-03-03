<?php
    $name = Route::currentRouteName();

    switch ($name) {
        case 'products.index':
            $shop = true;
            break;
        default:
            $home = true;
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
                    <li><a href="#">Cart</a></li>
                    <li><a href="#">Checkout</a></li>
                    <li><a href="#">Category</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>  
        </div>
    </div>
</div> <!-- End mainmenu area -->