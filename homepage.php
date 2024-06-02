<?php
include_once 'database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $sql = "SELECT * FROM users WHERE id='$userId'";
    $users = mysqli_query($connect, $sql);


    

    if(mysqli_num_rows($users) > 0) {
        $user = mysqli_fetch_assoc($users);

        if($user['isAdmin'] === 'Yes'){
            $_SESSION['isAdmin']=true;
        }else{
            $_SESSION['isAdmin']=false;
        }

    } else {
        echo "Please login the system";
    }


    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: homepage.php");
        exit(); 
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Homepage</title>
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
                <li><a href="#aboutus">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <?php
                if(isset($_SESSION['userId'])){?>
                    <li><a href="wishlist.php" title="Wish_list"><i class="fa-solid fa-heart"></i></a></li>
                    <li><a href="cart.php" title="Cart"><i class="fa-solid fa-cart-shopping"></i></a></li>
                    <li><a href="profile.php" title="Profile"><i class="fa-solid fa-user"></i></a></li>
                    <li><a href="?logout" title="Log Out"><i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>
                <?php
                }else{?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php
                }?>
                
            </ul>
        </nav>    
    </div>

    <div class="banner-container">
        <div class="banner-text">
            <h1>All New Phones </h1>
            <h1>Up to <span>25</span>% Flat Sale</h1>
            <br><br>
            <p>it is a long established fact that a reader will be distracted by the readable contentof a page when looking at its layout. The point of using Lorem Ipsum is that</p>
            
            <button class="home-btn" style="margin-top: 5vh;width: 10vw;" onclick="window.location.href='shop.php'">Shop Now </button>
        </div>    
    </div>

    <div class="aboutus" id="aboutus">
        <div class="header">About Us</div>
        <div class="aboutus-row">
            <div class="col2">
                <img src="https://media.istockphoto.com/id/1316576464/photo/smartphones-store-showcase-with-selling-various-new-smartphones-in-electronics-store-during-a.jpg?s=1024x1024&w=is&k=20&c=DKkzsFTNq5SYUeTJmBdJZFRJ_pi7ifWxmGsOVag4m5c=" alt="">
            </div>
            <div class="col2">
                <h1 style="margin-bottom: 12vh;">Our Mobile Shop</h1>
                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of It is a long established fact that a reader will be distracted by the</p>
            </div>
        </div>
    </div>

    <div class="brands" id="brands">
        <div class="header">Our Brand</div>

        <div class="barnd-row">
            <div class="brand-box">
                <img src="https://qph.cf2.quoracdn.net/main-qimg-b0923c97c59a6f627f34953722626704-lq" alt="">

            </div>
            <div class="brand-box">
                <img src="https://logowik.com/content/uploads/images/989_samsung.jpg" alt="">
            </div>
            <div class="brand-box">
                <img src="https://logowik.com/content/uploads/images/443_huawei.jpg" alt="">
            </div>
            <div class="brand-box">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTAVXqI7sBprOyN7rRVR8pcRtyQSvfWDMlDVdVbZO0-Rg&s" alt="">    
            </div>
            <div class="brand-box">
                <img src="https://www.shutterstock.com/image-vector/google-pixel-log-brand-portable-260nw-2377054495.jpg" alt="">
            </div>
        </div>
    </div>


    <div class="feedback" id="feedback">
        <div class="header">What Say Our Clients</div>
        <div class="feedback-row">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR6uqoCOqRqXYn3WjV09dgGY8IwJ6G4jd5X9ZyI-sIqvx3KF8XtGs2Vi_7-93ztOccxJ4s&usqp=CAU"  width="100vh" alt="">
            <div class="feedback-box">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                <h2 style="margin-top: 4vh;">-Lakshan-</h2>
            </div>
        </div>
    </div>


    <div class="contact" id="contact">
        <div class="header">Contact Us</div>

        <form   class="contact-form" action="">
            <input type="text" placeholder="Name"><br>
            <input type="text" placeholder="Email"><br>
            <input type="text" placeholder="Phone"><br>
            <textarea name="message" rows="5" placeholder="Message"></textarea><br>
            <button class="home-btn">Send Meassage</button>
        </form>

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