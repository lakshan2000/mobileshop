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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Productpage</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://kit.fontawesome.com/ac1e60548d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include_once 'components/header.php';
    ?>


    <?php
    if(mysqli_num_rows($products) > 0) {
        $product = mysqli_fetch_assoc($products);
    ?>
        <div class="product-container">
        <div class="col2">
            <div class="main-img-box">
                <img id="mainImg"  src="images/productImg/<?php echo $product['mainImg'] ?>" alt="mainImg">
            </div>
            <div class="other-imgs">
                <img id="img1" src="images/productImg/<?php echo $product['img1'] ?>" alt="img1" onclick="swapImg(1)">
                <img id="img2" src="images/productImg/<?php echo $product['img2'] ?>" alt="img2" onclick="swapImg(2)">
                <img id="img3" src="images/productImg/<?php echo $product['img3'] ?>" alt="img3" onclick="swapImg(3)">
                <img id="img4" src="images/productImg/<?php echo $product['img4'] ?>" alt="img4" onclick="swapImg(4)">
            </div>
        </div>
        <div class="col2">
            <h1 style="margin: 5vh 0;"><?php echo $product['productName'] ?></h1>
            <p><?php echo $product['ram'] . 'GB RAM | '.$product['storage'].'GB ROM'?></p>
            <p><?php echo $product['camera']?> MP Camera</p>
            
            <h2 class="price">Rs.<?php echo  $product['price']?>.00</h2>
        
            <p>Available Quantity:<?php echo $product['quantity'] ?></p>
           
            <br>
            <a href="<?php echo isset($userId) ? 'payment.php?productId='.$product['productId']:'login.php' ?>"><button class="home-btn">Buy Now</button></a>

            <hr style="margin: 5vh 0;">
            <p><i class="fa-solid fa-shield"></i> Safe payments :  <i>Payment methods used by many international shoppers.</i></p>
            <p><i class="fa-solid fa-lock"></i> Security & privacy : <i>We respect your privacy so your personal details are safe.</i></p>
            <p><i class="fa-solid fa-handshake"></i> Buyer protection : <i>Get your money back if your order isn't delivered by estimated date or if you're not satisfied with your order.</i></p>
        </div>
    </div>


    <?php
    }
    ?>








    <?php
        include_once 'components/footer.php';
    ?>


    <script>

        
        function swapImg(input){
            let mainImg = document.getElementById('mainImg');
            let img = document.getElementById(`img${input}`);
            let temp = mainImg.src;

            mainImg.src = img.src;
            img.src = temp;


        }

    </script>
    

    
</body>
</html>