<?php
include_once 'database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];

    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: homepage.php");
        exit(); 
    }


    $sql = "SELECT * FROM cart 
            INNER JOIN products ON cart.productId=products.productId
            WHERE userId='$userId'";
    $cartItems = mysqli_query($connect, $sql);


    if(isset($_POST['remove'])){
        $productId = $_POST['productId'];
        $sql = "DELETE FROM cart WHERE userID=$userId AND productId=$productId";
        $removeItem = mysqli_query($connect, $sql);

        if($removeItem){
            echo "Item Removed From cart";
            header("Location: cart.php");
            exit(); 
        }else{
            echo "Error";
        }
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Cart</title>
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
        <div class="header">Your Cart</div>
        <?php
        if(mysqli_num_rows($cartItems) > 0) {
        ?>
        <div class="payment-row cart-row">
            
            <table>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Balance</th>
                </tr>

                <?php
                while($cartItem = mysqli_fetch_assoc($cartItems)){
                ?>
                <form action="" method="post">
                    <tr>
                        <td>
                            <img src="<?php echo $cartItem['mainImg']?>" alt="">
                            <p><?php echo $cartItem['productName']?></p>
                        </td>                   
                        <td><?php echo $cartItem['price']?></td>
                        <td>
                            <div class="box-btn-raw">
                                <button class="cartWishlist-btn" title="+1"><i class="fa-solid fa-plus"></i></i></button>
                                <h4 name="quantity">1</h4>
                                <button class="cartWishlist-btn" title="-1"><i class="fa-solid fa-minus"></i></i></button>
                                <input name='productId' type="hidden" value="<?php echo  $cartItem['productId'] ?>">
                            </div>
                        </td>
                        <td>Rs.264,987.00</td>
                        <td>
                            <button type="submit" name="remove" style="margin: 30%;" class="home-btn"  title="Remove" ><i class="fa-solid fa-trash"></i></button>    
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr style="box-shadow:none">
                        <td><b>Total Bill</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Rs.567,665.00</b></td>
                    </tr>
                    <tr style="box-shadow:none">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <input style="width: 100%;" type="button" value="Check Out" class="home-btn" onclick="document.getElementById('payment-form').style.display='block'">                    
                        </td>
                    </tr>
                </form>
            </table>
        </div>

        <form id="payment-form" action="">
            <fieldset>
                <legend><b>Payments Details</b></legend>
                <div class="header" style="font-size: 20px;">Total Pay : Rs. 546,000.00</div>
                <input type="text" name="fullName" placeholder="Full Name">
                <input type="text" name="address1" placeholder="Address Line 01">
                <input type="text" name="address2" placeholder="Address Line 02">
                <input type="text" name="address3" placeholder="Address Line 03">
                <input type="text" name="zip" placeholder="Zip Code">
                <input type="text" name="mobile" placeholder="Mobile Number">
                <div style="width: 100%;margin: 2vh 0;">
                    <input style="width: 10%;" type="radio" id="onlinePay" name="paymentMethode" value="Online Payment" onclick="document.getElementById('card-details').style.display='block'">
                    <label for="html">Online Pay</label>
                    <input style="width: 10%;" type="radio" id="cashOnDelvery" name="paymentMethode" value="cashOnDelvery" onclick="document.getElementById('card-details').style.display='none'">
                    <label for="cashOnDelvery">Cash On Delvery</label>
                </div>

                <div class="card-details" id="card-details">
                    <input type="text" name="cardNumber" placeholder="xxxx xxxx xxxx xxxx">
                    <input type="text" name="expiryDate" placeholder="MM/YY">
                    <input type="text" name="CVC" placeholder="CVC">
                </div>
                <br>
                <input  class="home-btn" type="button" value="Place Order" onclick="alert('Order Placed Successfully')"> 
            </fieldset>
        </form> 

         <?php
         }else{
         ?>
        <div class="empty-box">
            <h1>Cart Is Empty !!!</h1>
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