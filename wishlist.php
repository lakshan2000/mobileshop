<?php
include_once 'database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];

    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: homepage.php");
        exit(); 
    }


    $sql = "SELECT * FROM wishlist 
            INNER JOIN products ON wishlist.productId=products.productId
            WHERE userId='$userId'";
    $wishListItems = mysqli_query($connect, $sql);


    if(isset($_POST['remove'])){
        $productId = $_POST['productId'];
        $deleteSql = "DELETE FROM wishlist WHERE userID='$userId' AND productId='$productId'";
        $removeItem = mysqli_query($connect, $deleteSql);

        if($removeItem){
            echo "Item Removed From Wishlist"; 
            header("Location: wishlist.php");
            exit(); 
        }
    }
    if(isset($_POST['addToCart'])){
        $productId = $_POST['productId'];

        $checkSql = "SELECT * FROM cart WHERE userID='$userId' AND productId='$productId'";
        $checkResult = mysqli_query($connect, $checkSql);

        if(mysqli_num_rows($checkResult ) > 0){
            echo "Item Already in the Cart";
        }else{
            $sql = "INSERT INTO cart (userId, productId) VALUES ('$userId',' $productId')";
            $addToCart = mysqli_query($connect, $sql);

            if($addToCart){
                echo "Item Added to Cart";
            } else {
                echo "Error adding item to cart";
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Wishlist</title>
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

    <div class="payment-container">
        <div class="header">Your Wish-List</div>
        <?php
        if(mysqli_num_rows($wishListItems) > 0) {
        ?>
        <div class="payment-row wishlist-row">
            <table>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                </tr>
                <?php
                while($wishListItem = mysqli_fetch_assoc($wishListItems)){
                ?>
                <tr>
                    <td>
                        <img src="<?php echo $wishListItem['mainImg']?>" alt="">
                        <p><?php echo $wishListItem['productName']?></p>
                    </td>
                    <td><?php echo 'Rs.'. $wishListItem['price']?></td>
                    <td>
                        <form style="margin:10% 30%"  method="post">
                            <input name='addToCart' type="submit" value="Add to Cart" class="home-btn" >
                            <input type="button" value="Buy Now" class="home-btn" onclick="window.location.href = 'payment.php?productId=<?php echo $wishListItem['productId']?>';">
                            <input name='remove' type="submit" value="Remove" class="home-btn" >
                            <input name='productId' type="hidden" value="<?php echo $wishListItem['productId'] ?>">
                        </form>
                    </td>
                </tr> 
                <?php
                }
                ?>
            </table>
        </div>
        <?php
        }else{
        ?>

        <div class="empty-box">
            <h1>Wish List Is Empty !!!</h1>
        </div>
        <?php
        }
        ?>
        
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