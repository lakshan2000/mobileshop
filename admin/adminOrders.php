<?php
include_once '../database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];


    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: homepage.php");
        exit(); 
    }


    $ordersSql = "SELECT * FROM orders 
              INNER JOIN orderDetails ON orders.orderId = orderDetails.orderId 
              INNER JOIN products ON orderDetails.productId = products.productId 
              INNER JOIN users ON  orders.userId = users.Id
              ORDER BY orders.orderId DESC";

    $orders = mysqli_query($connect, $ordersSql);


}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Admin - Orders</title>
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
                <li><a href="../homepage.php" title="Log Out"><i class="fa-solid fa-arrow-right-from-bracket"></i></i></a></li>
            </ul>
        </nav> 
    </div>


    <div class="payment-container">
        <div class="header" style="margin-bottom: 0;" >Admin - Orders</div>

        <?php
        if(mysqli_num_rows($orders) > 0){
        ?>
        <form action="" method="post"  style="width: 90%;">
            <div class="order-container" >
                <div class="order-row">
                    <table >
                        <tr>
                            <th>Date</th>
                            <th>Customer Details</th>
                            <th>Reciver Details</th>
                            <th>Items</th>
                            <th>Quantity</th>
                            <th>Total Bill</th>
                            <th>Methode</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        while($order = mysqli_fetch_assoc($orders)){
                        ?>
                        <tr style="font-size: 13px;">
                            <td><?php echo $order['orderDate'] ?></td>
                            <td>
                                <p><?php echo $order['firstName'].' '.$order['lastName']?></p>
                                <p><?php echo $order['email'] ?></p>
                                <p><?php echo $order['mobile'] ?></p>
                            </td>
                            <td>
                                <p><?php echo $order['fullName'] ?></p>
                                <p><?php echo $order['reciverMobile'] ?></p>
                                <p>zip : <?php echo  $order['zipcode'] ?></p>
                                <p><?php echo $order['orderAdressLine1'] ?></p>
                                <p><?php echo $order['orderAdressLine2'] ?></p>
                                <p><?php echo $order['orderAdressLine3'] ?></p>
                            </td>
                            <td>
                                <p>samsung S11</p>
                                <p>Pixel5</p>
                            </td>
                            <td>
                                <p>1</p>
                                <p>1</p>
                            </td>
                            <td>Rs.675,900.00</td>
                            <td><input  style="font-size: 12px; width: 80%;" type="button" value="Online" class="home-btn" readonly></td>
                            <td>
                                <input  style="font-size: 12px; width: 80%;" type="button" value="Ship" class="home-btn" >
                                <input  style="font-size: 12px; width: 80%;" type="button" value="Delivered" class="home-btn" >
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </form>
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
