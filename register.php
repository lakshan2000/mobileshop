<?php
include_once 'database/connection.php';

if(isset($_POST['regSubmitBtn'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if($password == $confirmPassword){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $checkEmailSql = "SELECT * FROM users where email = '$email'";
        $checkEmail = mysqli_query($connect, $checkEmailSql);
        
        if(mysqli_num_rows($checkEmail) > 0) {
            echo 'Email already exist';
        }else{
            $sql = "INSERT INTO users (firstName, lastName, email, mobile,password) VALUES ('$firstName', '$lastName', '$email','$mobile', '$hashedPassword')";

            if (mysqli_query($connect, $sql)) {
                echo "Register successfully login now Please";
                header("Location: login.php");
                exit();
            } else {
                echo "Error: ". "<br>" . mysqli_error($conn);
            }
        }
    }else{
        echo "Passwords are doesnot match ";
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileHub | Register</title>
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

    <div class="logReg-container " style="background: url();">
        <div class="col2">
            <img src="https://img.freepik.com/free-vector/registration-form_23-2147981065.jpg" width="100%" height="100%">
        </div>
    
        <div class="col2">
            <div class="logReg-form">
                <h1 style="margin-bottom: 4vh">Register</h1>
                <form action="" method="post">
                    <input name="firstName" type="text" placeholder="First Name" required><br>
                    <input name="lastName" type="text" placeholder="Last Name" required><br>
                    <input name="email" type="text" placeholder="Email" required><br>
                    <input name="password" type="password" placeholder="Password" required><br>
                    <input name="confirmPassword" type="password" placeholder="Confirm Password" required><br>
                    <button name="regSubmitBtn" type="submit" class="home-btn">Register</button>
                    <p>Already Have Account ? <a href="login.php">login</a></p>
                </form>
            </div>
        </div>
    </div>




    <?php
        include_once 'components/footer.php';
    ?>
</body>
</html>