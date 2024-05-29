<?php
include_once 'database/connection.php';

if(isset($_POST['logSubmitBtn'])){
    $email = $_POST['email'];
    $inputPassword = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $users = mysqli_query($connect, $sql);

    if(mysqli_num_rows($users) > 0) {
        $user = mysqli_fetch_assoc($users);
        $hashedPassword = $user['password'];

        if(password_verify($inputPassword, $hashedPassword)){
            echo "Login Successfully";
            $_SESSION['userId'] = $user['id'];
            header("Location: homepage.php");
            exit();

        } else {
            echo "Incorrect password";
        }
    } else {
        echo "Email does not exist";
    }


}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Login</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="images/logo.png">
        </div>
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>    
    </div>


    <div class="logReg-container">
        <div class="col2">
            <img src="https://img.freepik.com/free-vector/login-concept-illustration_114360-739.jpg?t=st=1716153111~exp=1716156711~hmac=3f6a27d6408395302c3efb08dfb1c54587edf5cc894f0cb5f93e761ee494baff&w=740" width="90%" height="100%" alt="">
        </div>
        
        <div class="col2">
            <div class="logReg-form">
                <h1 style="margin-bottom: 4vh">Login</h1>
                <form action="" method="post">
                    <input  name="email" type="text" placeholder="Email" required><br>
                    <input  name="password" type="text" placeholder="password" required><br>
                    <button name="logSubmitBtn" type="submit" class="home-btn">Login</button>
                    <p>Don't Have Account Yet ? <a href="register.php">Register</a></p>
                </form>
            </div>
        </div>
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