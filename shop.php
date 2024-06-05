<?php
include_once 'database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];


    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: homepage.php");
        exit(); 
    }

    if(isset($_POST['addToCart'])){
        $productId = $_POST['productId'];

        $checkSql = "SELECT * FROM cart WHERE userID='$userId' AND productId='$productId'";
        $checkResult = mysqli_query($connect, $checkSql);

        if(mysqli_num_rows($checkResult ) > 0){
            echo "Item Already in the Cart";
        }else{
            $sql = "INSERT INTO cart (userId, productId) VALUES ('$userId', '$productId')";
            $addToCart = mysqli_query($connect, $sql);

            if($addToCart){
                echo "Item Added to Cart";
            } else {
                echo "Error adding item to cart";
            }
        }
    }
    if(isset($_POST['addToWishlist'])){
        $productId = $_POST['productId'];

        $checkSql = "SELECT * FROM wishlist WHERE userID=$userId AND productId=$productId";
        $checkResult = mysqli_query($connect, $checkSql);

        if(mysqli_num_rows($checkResult ) > 0){
            echo "Item Already in the wishlist";
        }else{
            $sql = "INSERT INTO wishlist (userId, productId) VALUES ($userId, $productId)";
            $addToWishlist = mysqli_query($connect, $sql);

            if($addToWishlist){
                echo "Item Added to wishlist";
            } else {
                echo "Error adding item to wishlist";
            }
        }
    }


}else{
    if(isset($_POST['addToCart'])|| isset($_POST['addToWishlist'])){
        header("Location: login.php");
        exit(); 
    }
}

$productsSql = 'SELECT * FROM products';
$products = mysqli_query($connect, $productsSql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Shop</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://kit.fontawesome.com/ac1e60548d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include_once 'components/header.php';
    ?>

    <div class="shop-container">
        <div class="header">Feauture Items</div>
        <?php
        $productCount = 0;
        if(mysqli_num_rows($products) > 0) {
        ?>
        <div class="row-container">  
            <?php
            while($product = mysqli_fetch_assoc($products)){
                $productCount++;
            ?>
            <div class="box" onclick="window.location.href='product.php?productId=<?php echo $product['productId'] ?>'">
                <img src="images/productImg/<?php echo $product['mainImg'] ?>" alt="">
                <h4><?php echo $product['productName'] ?></h4>
                <p><?php echo $product['camera'].'' ?></p>
                <p><?php echo $product['ram'] . 'GB RAM | '.$product['storage'].'GB ROM'?></p>
                            
                <form class="box-btn-raw" action="" method="post">
                    <button name="addToWishlist" class="cartWishlist-btn" title="Add to Wish-List"><i class="fa-solid fa-heart"></i></button>
                    <button class="home-btn"><?php echo 'Rs.'.$product['price']?></button>
                    <button name="addToCart" class="cartWishlist-btn" title="Add to Cart"><i class="fa-solid fa-cart-shopping"></i></button>
                    <input name='productId' type="hidden" value="<?php echo $product['productId']?>" >
                </form>
            </div>

            <?php
            if ($productCount % 4 == 0) {
                echo '</div><div class="row-container">';
            }
            
            }
            ?>        
        </div>

        <?php
        }else{
        ?>
        <div class="empty-box">
            <h1>Products Empty!!!</h1>
        </div>
        <?php 
        }
        ?>>


    </div>




    <?php
        include_once 'components/footer.php';
    ?>
    

    
</body>
</html>