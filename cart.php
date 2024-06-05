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
        $sql = "DELETE FROM cart WHERE userID='$userId' AND productId='$productId'";
        $removeItem = mysqli_query($connect, $sql);

        if($removeItem){
            echo "Item Removed From cart";
            header("Location: cart.php");
            exit(); 
        }else{
            echo "Error";
        }
    }
    

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];
    
        $update_quantity_sql = "UPDATE cart SET cartQuantity='$quantity' WHERE userId='$userId' AND productId='$productId'";
        $update_quantity_result = mysqli_query($connect, $update_quantity_sql);
    
        if (!$update_quantity_result) {
            echo "Error updating quantity in the database";
            exit();
        }

        echo "Quantity updated successfully";
        exit(); 
    }


    if(isset($_POST['placeOrderBtn'])) {
    
        $errors = array(); 
    
        $fullName = $_POST['fullName'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $address3 = $_POST['address3'];
        $zip = $_POST['zip'];
        $mobile = $_POST['mobile'];
        $date = date('Y-m-d');
        $paymentMethode = $_POST['paymentMethode'];
        $totalBill =0;

        $sql = "SELECT * FROM cart 
            INNER JOIN products ON cart.productId=products.productId
            WHERE userId='$userId'";
        $cartItems = mysqli_query($connect, $sql);
        while($cartItem = mysqli_fetch_assoc($cartItems)){
            $totalBill +=$cartItem['price']*$cartItem['cartQuantity'];
        }


    
        if(empty($mobile )) {
            $errors[] = "Mobile number is required";
        } elseif (!preg_match('/^\d{10}$/', $mobile )) {
            $errors[] = "Mobile number Invalid";
        }
        if(empty($zip )) {
            $errors[] = "Zip code  is required";
        } elseif (!preg_match('/^\d{5}$/', $zip )) {
            $errors[] = "Zip code Invalid";
        }
        
    
        if($_POST['paymentMethode'] === 'Online Payment') {
            $cardNumber = $_POST['cardNumber'];
            $expiryDate = $_POST['expiryDate'];
            $cvc = $_POST['CVC'];
            $paymentMethode = 'Online';
    
            if(empty($cardNumber)) {
                $errors[] = "Card number is required";
            } elseif (!preg_match('/^\d{16}$/', $cardNumber)) {
                $errors[] = "Card number must have 16 numbers";
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
            $orderSql = "INSERT INTO orders (userId, orderDate, fullName, reciverMobile, orderAdressLine1, orderAdressLine2, orderAdressLine3, zipcode, paymentMethode,totalBill,status) 
                    VALUES ('$userId','$date','$fullName', '$mobile', '$address1', '$address2', '$address3', '$zip',  '$paymentMethode', '$totalBill', 'Processing..')";
            $placeOrder = mysqli_query($connect, $orderSql);
    
            if($placeOrder){
                $orderId = mysqli_insert_id($connect);

                $cartSql = "SELECT * FROM cart WHERE userId='$userId'";
                $carttems = mysqli_query($connect, $cartSql );

                while ($cartItem = mysqli_fetch_assoc($carttems)) {
                    $productId = $cartItem['productId'];
                    $quantity = $cartItem['cartQuantity'];

                    $orderDetailsSql = "INSERT INTO orderDetails (orderId, productId, orderQuantity) 
                                        VALUES ('$orderId', '$productId', '$quantity')";
        
                    $placeOrderDetails = mysqli_query($connect, $orderDetailsSql);
        
                    if($placeOrderDetails){
                        echo "Order Placed Successfully";
                    } else {
                        $deleteSql = "DELETE * FROM orders WHERE orderId = '$orderId'";
                        $deleteOrder = mysqli_query($connect, $deleteSql);
                        echo " Error!!! - Order Not Placed";
                    }
                }
                
                $cleaCartSql = "DELETE FROM cart WHERE userId='$userId'";
                $clearCartItems = mysqli_query($connect, $cleaCartSql);

                if ($clearCartItems) {
                    header("Location: profile.php");
                    exit();
                } else {
                    echo "Error clearing cart";
                    exit();
                }
            } else {
                echo "Error inserting order";
                exit();
            }
        }
    }
    
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
    <title>MobileHub | Cart</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://kit.fontawesome.com/ac1e60548d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include_once 'components/header.php';
    ?>

    <div class="payment-container">
        <div class="header">Your Cart</div>
        <?php   
        if(mysqli_num_rows($cartItems) > 0) {
            $total =0;
        ?>
        <div class="payment-row">
            
            <table>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Balance</th>
                </tr>

                <?php
                while($cartItem = mysqli_fetch_assoc($cartItems)){
                    $index =  $cartItem['productId'];
                    $total = $total + (int)$cartItem['price'];   
                ?>
                    <tr>         
                        <form id="myForm" method="post">
                            <td>
                                <img src="<?php echo $cartItem['mainImg']?>" alt="">
                                <p><?php echo $cartItem['productName']?></p>
                            </td>                   
                            <td id="itemPrice<?php echo $index ?>">Rs.<?php echo $cartItem['price']?>.00</td>
                            <td>
                                <div class="box-btn-raw" >
                                    <i class="fa-solid fa-minus" onclick="quantitySet('minus', '<?php echo $index ?>','<?php echo $total ?>')" ></i>
                                    <input style="background: none;border:none;" type="button"id='quantity<?php echo $index ?>' value="1" >
                                    <i class="fa-solid fa-plus"   onclick="quantitySet('plus','<?php echo $index ?>','<?php echo $total ?>')" ></i>
                                    <input name='productId' type="hidden" value="<?php echo $index ?>" >
                                </div>
                            </td>
                            <td  id="totalBill<?php echo $index ?>">Rs.<?php echo $cartItem['price']?>.00</td>
                            <td>
                                <button type="submit" name="remove" style="margin: 30%;" class="home-btn"  title="Remove" ><i class="fa-solid fa-trash"></i></button>    
                            </td>
                        </form>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr style="box-shadow:none">
                        <td><b>Total Bill</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td >
                            <b id="checkoutBill">Rs.<?php echo $total ?>.00</b>
                        </td>
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

        <form id="payment-form" method="post">
            <fieldset>
                <legend><b>Payments Details</b></legend>
                <div class="header" style="font-size: 20px;">Total Pay :  <p id="lastBill" ><?php echo $total ?>.00</p></div>
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
                <input name="placeOrderBtn" class="home-btn" type="submit" value="Place Order"> 
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
    

    <?php
        include_once 'components/footer.php';
    ?>
    
    


    <script>
        function quantitySet(input, index, total) {
            let quantity = document.getElementById(`quantity${index}`);
            let hiddenQuantity = document.getElementById(`hiddenQuantity${index}`);

            let itemPriceString = document.getElementById(`itemPrice${index}`).innerHTML;
            let itemPrice = parseFloat(itemPriceString.match(/[0-9]+(?:\.[0-9]*)?/)[0]);

            let totalBill = document.getElementById(`totalBill${index}`);
            let bill = total;

            let checkoutBillString = document.getElementById(`checkoutBill`).textContent;
            let checkoutBill = parseFloat(checkoutBillString.match(/[0-9]+(?:\.[0-9]*)?/)[0]);

            if (input === 'plus') {
                quantity.value++;
                bill = quantity.value * itemPrice;
                checkoutBill += itemPrice;
            } else if (input === 'minus' && quantity.value > 1) {
                quantity.value--;
                bill = quantity.value * itemPrice;
                checkoutBill -= itemPrice;
            }

            totalBill.textContent = 'Rs.' + bill.toFixed(2);
            document.getElementById(`checkoutBill`).textContent = 'Rs. ' + checkoutBill.toFixed(2);
            document.getElementById(`lastBill`).textContent = 'Rs.' + checkoutBill.toFixed(2);

            // Send AJAX request to update quantity in the database
            let productId = document.querySelector(`input[name="productId"][value="${index}"]`).value;
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                    } else {
                        console.error('Error:', xhr.status);
                    }
                }
            };
            xhr.send(`productId=${productId}&quantity=${quantity.value}&update_quantity=1`);
        }
    </script>

</body>
</html>