<div class="navbar">
    <div class="logo">
        <img src="images/logo.png">
    </div>
    <nav>
        <ul>
            <?php
            if(isset($_SESSION['userId']) && $_SESSION['isAdmin']){
                echo '<li><a href="admin/admindahsbord.php">Admin</a></li>';
            }
            ?>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="shop.php">Shop</a></li>                
            <li><a href="<?php echo isset($_SESSION['userId'])?  'wishlist.php' : 'login.php' ?>" title="Wish_list"><i class="fa-solid fa-heart"></i></i></a></li>
            <li><a href="<?php echo isset($_SESSION['userId'])?  'cart.php' : 'login.php' ?>" title="Cart"><i class="fa-solid fa-cart-shopping"></i></a></li>
            <li><a href="<?php echo isset($_SESSION['userId'])?  'profile.php' : 'login.php' ?>" title="Profile"><i class="fa-solid fa-user"></i></a></li>
            <li><a href="?logout" title="Log Out"><i class="fa-solid fa-arrow-right-from-bracket"></i></i></a></li>
        </ul>
    </nav>    
</div>
