<?php
include_once 'database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];

    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: homepage.php");
        exit(); 
    }

    
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

    $ordersSql = "SELECT DISTINCT orderId, orderDate, totalBill, status FROM orders WHERE userId='$userId' ORDER BY orders.orderId DESC";
    $orders = mysqli_query($connect, $ordersSql);


}else{
    header("Location: homepage.php");
    exit();
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
    <?php
        include_once 'components/header.php';
    ?>

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
                            $orderId = $order['orderId'];
                        ?>
                        <tr>
                            <td><?php echo $orderId ?></td>
                            <td><?php echo $order['orderDate']?></td>
                            <?php
                            
                            ?>

                            <td>
                                <?php
                                $sql = "SELECT * FROM orderDetails
                                        INNER JOIN products ON orderDetails.productId = products.productId 
                                        WHERE orderId = '$orderId'";
                                $results = mysqli_query($connect, $sql);

                                
                                if(mysqli_num_rows($results) > 0) {
                                    while($result = mysqli_fetch_assoc($results)){        
                                    ?>
                                    <p><?php echo $result['productName']?></p>
                                    <?php
                                    }
                                }
                                    ?>
                            </td>
                            <td>
                                <?php
                                $sql = "SELECT * FROM orderDetails
                                        INNER JOIN products ON orderDetails.productId = products.productId 
                                        WHERE orderId = '$orderId'";
                                $results = mysqli_query($connect, $sql);

                                
                                if(mysqli_num_rows($results) > 0) {
                                    while($result = mysqli_fetch_assoc($results)){        
                                    ?>
                                    <p>Rs.<?php echo $result['price']?>.00</p>
                                    <?php
                                    }
                                }
                                    ?>
                            </td>
                            <td>
                                <?php
                                $sql = "SELECT * FROM orderDetails
                                        INNER JOIN products ON orderDetails.productId = products.productId 
                                        WHERE orderId = '$orderId'";
                                $results = mysqli_query($connect, $sql);

                                
                                if(mysqli_num_rows($results) > 0) {
                                    while($result = mysqli_fetch_assoc($results)){        
                                    ?>
                                    <p><?php echo $result['orderQuantity']?></p>
                                    <?php
                                    }
                                }
                                    ?>
                            </td>
                            <td>Rs.<?php echo $order['totalBill']?>.00</td>
                            <td>
                                <input type="button" value="<?php echo $order['status']?>" class="home-btn" readonly>
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


    <?php
        include_once 'components/footer.php';
    ?>

</body>
</html>