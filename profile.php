<?php
include_once 'database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $sql = "SELECT * FROM users WHERE id='$userId'";
    $users = mysqli_query($connect, $sql);
    

    if(mysqli_num_rows($users) > 0) {
        $user = mysqli_fetch_assoc($users);

        $firstName = $user['firstName'];
        $lastName = $user['lastName'];
        $email = $user['email'];
        $mobile = $user['mobile'];
        $addressLine1 = $user['addressLine1'];
        $addressLine2 = $user['addressLine2'];
        $addressLine3 = $user['addressLine3'];

    } else {
        echo "Please login the system";
    }

    $ordersSql = "SELECT * FROM orders 
              INNER JOIN orderDetails ON orders.orderId = orderDetails.orderId 
              INNER JOIN products ON orderDetails.productId = products.productId 
              WHERE userId = '$userId'
              ORDER BY orders.orderDate DESC";
    $orders = mysqli_query($connect, $ordersSql);


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Profile</title>
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
        <form action="">
            <fieldset>
                <legend><b>Your Details</b></legend>
                <div class="header" style="font-size: 50px;"><?php echo $firstName . " " .$lastName ?></div>
                <input type="text" name="email" value="<?php echo $email ?>" readonly>
                
                <input type="text" name="fullName" placeholder="Full Name">
                <input type="text" name="mobile" placeholder="Mobile Number">
                <input type="text" name="address1" placeholder="Address Line 01">
                <input type="text" name="address2" placeholder="Address Line 02">
                <input type="text" name="address3" placeholder="Address Line 03">
        
                   <input  class="home-btn" type="button" value="Update" onclick="alert('Order Placed Successfully')"> <!-- if methode = online ->Continue: cod -> placed Order -->
            </fieldset>
        </form>
        <?php
         if(mysqli_num_rows($orders) > 0) {
        ?>
        <form action="" method="post" style="width: 90%;"> 
            <fieldset class="order-container">
                <legend><b>Order Details</b></legend>
                <div class="order-row">
                    <table>
                        <tr>
                            <th>Order Id</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        while($order = mysqli_fetch_assoc($orders)){
                        ?>
                        <tr>
                            <td><?php echo $order['orderId']?></td>
                            <td><?php echo $order['orderDate']?></td>
                            <td>
                                <?php echo $order['productName']?>
                            </td>
                            <td>
                                <?php echo $order['price']?>
                            </td>
                            <td>
                                <?php echo $order['orderQuantity']?>
                            </td>
                            <td><?php echo $order['price']?></td>
                            <td>
                                <input type="button" value="Placed" class="home-btn" readonly>
                                <input type="button" value="Recieved" class="home-btn">
                            </td>
                        </tr> 
                        
                        <?php
                        }
                        ?>
                    </table>
                </div>


            </fieldset>
        </form>
        <?php
        }else{
        ?>

        <div class="empty-box">
            <h1>Not Order Placed Yet !!!</h1>
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