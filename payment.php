<?php
include_once 'database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];

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

if(isset($_POST['placeOrderBtn'])) {
    
    $errors = array(); 

    $fullName = $_POST['fullName'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $address3 = $_POST['address3'];
    $quantity = $_POST['quantity'];
    $zip = $_POST['zip'];
    $mobile = $_POST['mobile'];
    $date = date('Y-m-d');
    $paymentMethod = 'Cash On Delivery';

    if(empty($mobile )) {
        $errors[] = "Mobile number is required";
    } elseif (!preg_match('/^\d{10}$/', $mobile )) {
        $errors[] = "Mobile number Invalid";
    }
    if(empty($zip )) {
        $errors[] = "Mobile number is required";
    } elseif (!preg_match('/^\d{5}$/', $zip )) {
        $errors[] = "Zip code Invalid";
    }
    

    if($_POST['paymentMethode'] === 'Online Payment') {
        $cardNumber = $_POST['cardNumber'];
        $expiryDate = $_POST['expiryDate'];
        $cvc = $_POST['CVC'];
        $paymentMethod = 'Online';

        if(empty($cardNumber)) {
            $errors[] = "Card number is required";
        } elseif (!preg_match('/^\d{16}$/', $cardNumber)) {
            $errors[] = "Card number must have 12 numbers";
        }
        if(empty($expiryDate)) {
            $errors[] = "Expiry date is required";
        } else {
            $explodeExpiryDate = explode('/', $expiryDate);
            $month = (int)$explodeExpiryDate[0];
            $year = (int)$explodeExpiryDate[1];
            $currentYear = date('y');
            $currentMonth = date('m');
            if($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
                $errors[] = "Card Expired";
            }
        }
        if(empty($cvc)) {
            $errors[] = "CVC is required";
        } elseif (!preg_match('/^\d{3}$/', $_POST['CVC'])) {
            $errors[] = "CVC must have 3 numbers";
        }
    }

    if(!empty($errors)) {
        foreach($errors as $error) {
            echo "<p>$error</p>";
        }
    }else{
        $orderSql = "INSERT INTO orders (userId, orderDate, fullName, reciverMobile, orderAdressLine1, orderAdressLine2, orderAdressLine3, zipcode, paymentMethode) 
                VALUES ('$userId','$date','$fullName', '$mobile', '$address1', '$address2', '$address3', '$zip',  '$paymentMethod')";
        $placeOrder = mysqli_query($connect, $orderSql);

        if($placeOrder && $quantity>0 ){
            $orderId = mysqli_insert_id($connect);
            $orderDetailsSql = "INSERT INTO orderDetails (orderId, productId, orderQuantity) 
                                VALUES ('$orderId', '$productId', '$quantity')";

            $placeOrderDetails = mysqli_query($connect, $orderDetailsSql);

            if($placeOrderDetails){
                echo "Order Placed Successfully";
            } else {
                $deleteSql = "DELETE * FROM orders WHERE orderId = '$orderId'";
                $deleteOrder = mysqli_query($connect, $deleteSql);
            }
        } else{
            $deleteSql = "DELETE * FROM orders WHERE orderId = '$orderId'";
                $deleteOrder = mysqli_query($connect, $deleteSql);
            }
    }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Payment</title>
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
        While($product = mysqli_fetch_assoc($products)){;
    ?>
        <div class="payment-container">
        <div class="header">Place Order</div>
        <form action="" method="post">
        <div class="payment-row">
            <table>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Bill</th>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo $product['mainImg'] ?>" alt="">
                        <p><?php echo $product['productName'] ?></p>
                    </td>                   
                    <td id='itemPrice'><?php echo 'Rs.'.$product['price'] ?></td>
                    <td>
                        <div class="box-btn-raw" style="width:70%;margin-left:15%;font-size:18px">
                            <i class="fa-solid fa-plus" onclick="quantitySet('plus')" ></i>
                            <input style="background: none;border:none;" type="button"id='quantity' value="1" >
                            <input type="hidden" name="quantity" id="hiddenQuantity" value="1">
                            <i class="fa-solid fa-minus" onclick="quantitySet('minus')" ></i>
                        </div>
                    </td>
                    <td  id="totalBill"><?php echo 'Rs.'.$product['price'] ?></td>
                </tr>
            </table>
        </div>
        
        <fieldset>
             <legend><b>Payments Details</b></legend>
             <div class="header" style="font-size: 20px;" id="mainBill">Total Pay : <?php echo 'Rs.'.$product['price'] ?></div>
             <input type="text" name="fullName" placeholder="Full Name" required>
             <input type="text" name="address1" placeholder="Address Line 01" required>
             <input type="text" name="address2" placeholder="Address Line 02" required>
             <input type="text" name="address3" placeholder="Address Line 03">
             <input type="text" name="zip" placeholder="Zip Code" required>
             <input type="text" name="mobile" placeholder="Mobile Number" required>
             <div style="width: 100%;margin: 2vh 0;">
                 <input style="width: 10%;" type="radio" id="onlinePay" name="paymentMethode" value="Online Payment" onclick="document.getElementById('card-details').style.display='block'" required>
                 <label for="html">Online Pay</label>
                 <input style="width: 10%;" type="radio" id="cashOnDelvery" name="paymentMethode" value="cashOnDelvery" onclick="document.getElementById('card-details').style.display='none'" required>
                 <label for="cashOnDelvery">Cash On Delvery</label>
             </div>

             <div class="card-details" id="card-details">
                <input type="text" name="cardNumber" placeholder="xxxx xxxx xxxx xxxx" >
                <input type="text" name="expiryDate" placeholder="MM/YY" >
                <input type="text" name="CVC" placeholder="CVC" >
             </div>
             <br>
             <input  class="home-btn" type="submit" value="Place Order" name="placeOrderBtn" > 
         </fieldset>
         </form>
    </div>


    <?php
    }
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
    function quantitySet(input) {
    let quantity = document.getElementById('quantity');

    let itemPriceString = document.getElementById('itemPrice').innerHTML;
    let itemPrice = parseFloat(itemPriceString.match(/[0-9]+(?:\.[0-9]*)?/)[0]);

    let totalBill = document.getElementById('totalBill');
    let mainBill = document.getElementById('mainBill');

    if (input === 'plus') {
        quantity.value++;

        let bill = quantity.value * itemPrice;
        totalBill.textContent = 'Rs.' + bill.toFixed(2);
        mainBill.textContent =  'Total Pay : Rs.' + bill.toFixed(2);
    } else if (input === 'minus' && quantity.value > 0) {
        quantity.value--;

        let bill = quantity.value * itemPrice;
        totalBill.textContent = 'Rs.' + bill.toFixed(2); 
        mainBill.textContent =  'Total Pay : Rs.' + bill.toFixed(2);
    }

    document.getElementById('hiddenQuantity').value = quantity.value;

}


    </script>

    

    
</body>
</html>