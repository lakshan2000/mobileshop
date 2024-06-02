<?php
include_once 'database/connection.php';

if(isset($_SESSION['userId'])){


    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: homepage.php");
        exit(); 
    }
}

if(isset($_GET['productId'])) {
    $productId = $_GET['productId'];
    $productSql = "SELECT * FROM products where productId='$productId'";
    $products = mysqli_query($connect, $productSql);
    
} else {
    echo "Product ID not found in URL";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Productpage-</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://kit.fontawesome.com/ac1e60548d.js" crossorigin="anonymous"></script>
</head>
<body>
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
                <li><a href="<?php echo isset($_SESSION['userId'])?  'profile.php' : 'login.html' ?>" title="Profile"><i class="fa-solid fa-user"></i></a></li>
                <li><a href="?logout" title="Log Out"><i class="fa-solid fa-arrow-right-from-bracket"></i></i></a></li>
            </ul>
        </nav>    
    </div>


    <?php
    if(mysqli_num_rows($products) > 0) {
        $product = mysqli_fetch_assoc($products);
    ?>
        <div class="product-container">
        <div class="col2">
            <div class="main-img-box">
                <img id="mainImg" src="<?php echo $product['mainImg'] ?>" alt="">
            </div>
            <div class="other-imgs">
                <img id="img1" src="<?php echo $product['img1'] ?>" alt="" onclick="swapImg(1)">
                <img id="img2" src="<?php echo $product['img2'] ?>" alt="" onclick="swapImg(2)">
                <img id="img3" src="<?php echo $product['img3'] ?>" alt="" onclick="swapImg(3)">
                <img id="img4" src="<?php echo $product['img4'] ?>" alt="" onclick="swapImg(4)">
            </div>
        </div>
        <div class="col2">
            <h1 style="margin: 5vh 0;"><?php echo $product['productName'] ?></h1>
            <p><?php echo $product['ram'] . 'GB RAM | '.$product['storage'].'GB ROM'?></p>
            <p><?php echo $product['camera'].'' ?></p>
            
            <h2 class="price"><?php echo 'Rs.'.$product['price']?></h2>
        
            <p>Available Quantity: 23</p>
           
            <br>
            <button class="home-btn"><a href="payment.php?productId=<?php echo $product['productId'] ?>">Buy Now</a></button>
            <hr style="margin: 5vh 0;">
            <p><i class="fa-solid fa-shield"></i> Safe payments :  <i>Payment methods used by many international shoppers.</i></p>
            <p><i class="fa-solid fa-lock"></i> Security & privacy : <i>We respect your privacy so your personal details are safe.</i></p>
            <p><i class="fa-solid fa-handshake"></i> Buyer protection : <i>Get your money back if your order isn't delivered by estimated date or if you're not satisfied with your order.</i></p>
        </div>
    </div>


    <?php
    }
    ?>








    <div class="footer" id="footer">
        <div class="footer-row">
            <div class="col4">
                <div class="fHeader">Address</div>
                <p>A11/301</p>
                <p>Wattala Road,Ja Ela</p>
                <p>Colombo 05</p>
            </div>
            <div class="col4">
                <div class="fHeader">Open Hours</div>
                <p>Mon - Fri - 08:00 to 20.00</p>
                <p>Sat - 08:00 to 22.00</p>
                <p>Sun - 08:00 to 18.00</p>
            </div>
            <div class="col4">
                <div class="fHeader">Social Media</div>
                <p>Facebook</p>
                <p>Twitter</p>
                <p>Instragram</p>
            </div>
        </div>
    </div>


    <script>

        
        function swapImg(input){
            let mainImg = document.getElementById('mainImg');
            let img = document.getElementById(`img${input}`);
            let temp = mainImg.src;

            mainImg.src = img.src;
            img.src = temp;


        }

    </script>
    

    
</body>
</html>