<?php
include_once '../database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];


    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: ../homepage.php");
        exit(); 
    }


    if(isset($_POST['addProductBtn'])){
        $productName =$_POST['productName'];
        $ram =$_POST['ram'];
        $camera =$_POST['camera'];
        $storage =$_POST['storage'];
        $price =$_POST['price'];
        $quantity =$_POST['quantity'];
        $mainImg = $_FILES["mainImg"]["name"];
        $img1 = $_FILES["image1"]["name"];
        $img2 = $_FILES["image2"]["name"];
        $img3 = $_FILES["image3"]["name"];
        $img4 = $_FILES["image4"]["name"];
    

    $sql = "INSERT INTO products (productName, price, camera, ram, storage, quantity, mainImg, img1, img2, img3, img4) 
        VALUES ('$productName', '$price','$camera', '$ram', '$storage',' $quantity', '$mainImg', '$img1', '$img2', '$img3', '$img4')";

    $insertProduct = mysqli_query($connect, $sql);

    if($insertProduct){
        echo "Product Added Successfully";
        header("Location: adminProducts.php");
        exit();
    }else{
        echo 'Error';
    }
    }

    if(isset($_POST['deleteBtn'])){
        $productId = $_POST['productId'];

        $deleteSql = "DELETE FROM products WHERE productId = '$productId'";
        $deleteProduct = mysqli_query($connect, $deleteSql);

        if($deleteProduct){
            echo "Remove Product Successfully";
            header("Location: adminProducts.php");
            exit();
        }
    }

    if(isset($_POST['updateBtn'])){
        $productId = $_POST['productId'];
        $productName = $_POST['productName'];
        $upadetImg = $_FILES["upadetImg"]["name"];
        $camera = $_POST['camera'];
        $ram = $_POST['ram'];
        $storage = $_POST['storage'];
        $newPrice = $_POST['newPrice'];
        $availableQuantity = $_POST['availableQuantity'];
    
        $sql = "UPDATE products SET ";
    
        if (!empty($productName)) {
            $sql .= "productName='$productName', ";
        }
        if (!empty($upadetImg)) {
            $sql .= "mainImg='$upadetImg', ";
        }
        if (!empty($camera)) {
            $sql .= "camera='$camera', ";
        }
        if (!empty($ram)) {
            $sql .= "ram='$ram', ";
        }
        if (!empty($storage)) {
            $sql .= "storage='$storage', ";
        }
        if (!empty($newPrice)) {
            $sql .= "price='$newPrice', ";
        }
        if (!empty($availableQuantity)) {
            $sql .= "quantity='$availableQuantity', ";
        } 

        $sql = rtrim($sql, ", ");

        $sql .= " WHERE productId='$productId' ";

        $updateProduct = mysqli_query($connect, $sql);

        if($updateProduct){
            echo "Update Product Details Successfully";
            header("Location: adminProducts.php");
            exit();
        }
    }

    $productsSql = "SELECT * FROM products";
    $products = mysqli_query($connect, $productsSql);



}else{
    header("Location: ../homepage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Admin - Products</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://kit.fontawesome.com/ac1e60548d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include_once '../components/adminHeader.php';
    ?>

    <div class="payment-container" >
        <div class="header" style="margin-bottom: 0;" >Admin - Products</div>
        <div class="add-box" onclick="productAddform('show')">
            <i style="font-size: 150px;" class="fa-thin fa-plus"></i>
            <h5>Add New Product</h5>
        </div>
        <form id="add-form" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend><b>Add New Product</b></legend>
                <input type="text" name="productName" placeholder="Product Name" required>
                <input type="text" name="ram" placeholder="RAM" required>
                <input type="text" name="camera" placeholder="Camera" required>
                <input type="text" name="storage" placeholder="Storage" required>
                <input type="text" name="price" placeholder="Price" required>
                <input type="text" name="quantity" placeholder="Quantity" required>
                <div class="product-img-row">
                    <label for="image1">Product Image 1 : </label><input name="mainImg" type="file"  required>
                </div>
                <div class="product-img-row">
                    <label for="image2">Product Image 2 : </label><input name="image1" type="file"  required>
                </div>
                <div class="product-img-row">
                    <label for="image3">Product Image 3 : </label><input name="image2" type="file"  required>
                </div>
                <div class="product-img-row">
                    <label for="image4">Product Image 4 : </label><input name="image3" type="file"  required>
                </div>
                <div class="product-img-row">
                    <label for="image4">Product Image 5 : </label><input name="image4" type="file"  required>
                </div>
                <br>
                <input name='addProductBtn' class="home-btn" type="submit" value="Add Product">
                <br>
                <i style="font-size: 30px;color: red;"  class="fa-solid fa-circle-xmark" onclick="productAddform('hide')"></i>
            </fieldset>
        </form>
        
        <?php
        if(mysqli_num_rows($products) > 0){
        ?>
        <form action="" method="post" style="width: 90%;">
        <fieldset class="order-container">
            <legend><b>All Products</b></legend>
            <div class="order-row">
                <table>
                    <tr>
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Specification</th>
                        <th>Price</th>
                        <th>Available Quantity</th>
                        <th>Admin Option</th>
                    </tr>
                    <?php
                    while($product = mysqli_fetch_assoc($products)){
                    ?>
                    <form action="" method="post" enctype="multipart/form-data" >
                    <tr>
                        <td><?php echo $product['productName'] ?></td>
                        <td><img src="../images/productImg/<?php echo $product['mainImg'] ?>"width="20px" alt=""></td>                   
                        <td>
                            Camera:<?php echo $product['camera'] ?>MP<br>
                            Ram : <?php echo $product['ram'] ?>GB<br>
                            Stoarage : <?php echo $product['storage'] ?>GB
                        </td>
                        <td>Rs.<?php echo $product['price'] ?></td>
                        <td><?php echo $product['quantity'] ?></td>
                        <td>
                            <div class="box-btn-raw">
                                <p class="home-btn" title="Edit Product" onclick="callProductEditForm(<?php echo $product['productId'] ?>)"><i class="fa-solid fa-pen-to-square"></i></p>
                                <button name="deleteBtn" class="home-btn" title="Delete Product"><i class="fa-solid fa-trash"></i></button>
                                <input name='productId' type="hidden" value="<?php echo $product['productId']?>" >
                            </div>
                        </td>      
                    </tr> 
                    </form> 
                    <form action="" method="post" enctype="multipart/form-data">              
                    <tr class="product-Edit-Form" id="product-Edit-Form<?php echo $product['productId'] ?>">
                        <div >
                            <td><input name="productName" type="text" placeholder="<?php echo $product['productName'] ?>"></td>
                            <td><input name="upadetImg" type="file"></td>                   
                            <td>
                                <input name="camera" type="text" placeholder="Camera"><br>
                                <input name="ram" type="text" placeholder="Ram"><br>
                                <input name="storage" type="text" placeholder="Storage">
                            </td>
                            <td><input name="newPrice" type="text" placeholder="New price"></td>
                            <td><input name="availableQuantity" type="text" placeholder="Avilble quantity"></td>
                            <td>
                                <input type="submit" name="updateBtn" style="width: 100%;" value="Update" class="home-btn" width="100%">
                                <input name='productId' type="hidden" value="<?php echo $product['productId']?>" >
                            </td>   
                        </div>   
                    </tr>
                    </form> 
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
            <h1>Products Empty!!!</h1>
        </div>
        <?php 
        }
        ?>>

    </div>


    <?php
        include_once '../components/footer.php';
    ?>  
    
    


    <script>
        function callProductEditForm(id) {
            let productEditForm = document.getElementById(`product-Edit-Form${id}`);
            if (productEditForm.style.display === 'table-row' || productEditForm.style.display === '') {
                productEditForm.style.display = 'none';
            } else {
                productEditForm.style.display = 'table-row';
            }
        }

        function productAddform(input) {
            let productAddForm = document.getElementById(`add-form`);
            if (input === 'show') {
                productAddForm .style.display = 'block';
            } else if(input === 'hide'){
                productAddForm.style.display = 'none';
            }
        }

        showProductAddform()
    </script>

</body>
</html>
