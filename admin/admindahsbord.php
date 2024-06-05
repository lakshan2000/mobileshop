<?php
include_once '../database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];



    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: ../homepage.php");
        exit(); 
    }


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
    <title>MobileHub | Admin - Dashboard</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://kit.fontawesome.com/ac1e60548d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include_once '../components/adminHeader.php';
    ?>

    <div class="payment-container" >
        <div class="header" style="margin-bottom: 0;">Admin Page</div>
        <form  action="">
            <fieldset>
                <legend><b>Admin Options</b></legend>
                <input class="home-btn" type="button" name="Products" value="Products" onclick="window.location.href='adminProducts.php'">
                <input class="home-btn" type="button" name="Orders" value="Orders"  onclick="window.location.href='adminOrders.php'">
                <input class="home-btn" type="button" name="Messages" value="Messages" onclick="window.location.href='adminMessage.php'">
                <input class="home-btn" type="button" name="Admins" value="Admins" onclick="window.location.href='admin.php'">
                
            </fieldset>
    </div>


    <?php
        include_once '../components/footer.php';
    ?> 
</body>
</html>
