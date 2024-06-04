<?php
include_once '../database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];



    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: ../homepage.php");
        exit(); 
    }


}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Admin - Dashboard</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://kit.fontawesome.com/ac1e60548d.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="../images/logo.png">
        </div>
        <nav>
            <ul>
                <li><a href="admindahsbord.php">Admin</a></li>
                <li><a href="../homepage.php">Home</a></li>
                <li><a href="../shop.php">Shop</a></li>                
                <li><a href="../wishlist.php" title="Wish_list"><i class="fa-solid fa-heart"></i></i></a></li>
                <li><a href="../cart.php" title="Cart"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="../profile.php" title="Profile"><i class="fa-solid fa-user"></i></a></li>
                <li><a  href="?logout" title="Log Out"><i class="fa-solid fa-arrow-right-from-bracket"></i></i></a></li>
            </ul>
        </nav> 
    </div>

    <div class="payment-container" >
        <div class="header" style="margin-bottom: 0;">Admin Page</div>
        <form  action="">
            <fieldset>
                <legend><b>Admin Options</b></legend>
                <input class="home-btn" type="button" name="Products" value="Products" onclick="window.location.href='adminProducts.php'">
                <input class="home-btn" type="button" name="Orders" value="Orders"  onclick="window.location.href='adminOrders.php'">
                <input class="home-btn" type="button" name="Messages" value="Messages" onclick="window.location.href='adminMessage.php'">
                <input class="home-btn" type="button" name="Admin&Users" value="Admins" onclick="window.location.href='adminUser.php'">
                
            </fieldset>
    </div>


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
</body>
</html>
