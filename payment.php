<?php
include_once 'database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];

    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: homepage.php");
        exit(); 
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
        $paymentMethode = $_POST['paymentMethode'];

        $productPrice = $_POST['productPrice'];
        $totalBill =$quantity* $productPrice;

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
            $orderSql = "INSERT INTO orders (userId, orderDate, fullName, reciverMobile, orderAdressLine1, orderAdressLine2, orderAdressLine3, zipcode, paymentMethode, totalBill, status) 
                    VALUES ('$userId','$date','$fullName', '$mobile', '$address1', '$address2', '$address3', '$zip',  '$paymentMethode',' $totalBill', 'Processing')";
            $placeOrder = mysqli_query($connect, $orderSql);

            if($placeOrder && $quantity>0 ){
                $orderId = mysqli_insert_id($connect);
                $orderDetailsSql = "INSERT INTO orderDetails (orderId, productId, orderQuantity) 
                                    VALUES ('$orderId', '$productId', '$quantity')";

                $placeOrderDetails = mysqli_query($connect, $orderDetailsSql);

                if($placeOrderDetails){
                    echo "Order Placed Successfully";
                    header('Location: profile.php');
                    exit();
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
    <title>MobileHub | Payment</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://kit.fontawesome.com/ac1e60548d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include_once 'components/header.php';
    ?>

    <?php
    if(mysqli_num_rows($products) > 0) {
        While($product = mysqli_fetch_assoc($products)){;
    ?>
    <div class="payment-container">
        <div class="header">Place Order</div>
        <form action="" method="post">
        <div class="payment-row" >
            <table>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Bill</th>
                </tr>
                <tr>
                    <td>
                        <img src="images/productImg/<?php echo $product['mainImg'] ?>" alt="">
                        <p><?php echo $product['productName'] ?></p>
                    </td>                   
                    <td id='itemPrice'>
                        Rs.<?php echo $product['price'] ?>.00
                        <input type="hidden" name="productPrice" value="<?php echo $product['price'] ?>">
                    </td>
                    <td>
                        <div class="box-btn-raw">
                        <i class="fa-solid fa-minus" onclick="quantitySet('minus')" ></i>
                            <input style="background: none;border:none;" type="button"id='quantity' value="1" >
                            <input type="hidden" name="quantity" id="hiddenQuantity" value="1">
                            <i class="fa-solid fa-plus" onclick="quantitySet('plus')" ></i>
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







    <?php
        include_once 'components/footer.php';
    ?>

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