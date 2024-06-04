<?php
include_once '../database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];


    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: ../homepage.php");
        exit(); 
    }


    $usersSql = "SELECT * FROM users WHERE isAdmin='Yes'  ORDER BY id ASC";
    $users = mysqli_query($connect, $usersSql);

    if(isset($_POST['addAdminBtn'])){
        $firstName = $_POST['adminFirstName'];
        $lastName = $_POST['adminLastName'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if($password === $confirmPassword){
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $checkEmailSql = "SELECT * FROM users where email = '$email'";
            $checkEmail = mysqli_query($connect, $checkEmailSql);
            
            if(mysqli_num_rows($checkEmail) > 0) {
                echo 'Email already exist';
            }else{
                $sql = "INSERT INTO users (firstName, lastName, email, mobile,password,isAdmin) VALUES ('$firstName', '$lastName', '$email','$mobile', '$hashedPassword', 'Yes')";
    
                if (mysqli_query($connect, $sql)) {
                    echo "Register successfully login now Please";
                    header("Location: adminUser.php");
                    exit();
                } else {
                    echo "Error: ";
                }
            }
        }else{
            echo "Passwords are doesnot match ";
        }
    }

    if(isset($_POST['deleteAdminBtn'])){
        $sql = "DELETE FROM users WHERE id='$userId'";
        $deleteAdmin = mysqli_query($connect, $sql);

        if($deleteAdmin){
            echo "Admin Removed Successfully";
        }else{
            echo "Error";
        }
    }


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
    <div class="navbar">
        <div class="logo">
            <img src="../images/logo.png">
        </div>
        <nav>
            <ul>
                <li><a href="admindahsbord.php">Admin</a></li>
                <li><a href="../homepage.php">Home</a></li>
                <li><a href="../shop.php">Shop</a></li>                
                <li><a href="../wishlist.php" title="Wish_list"><i class="fa-solid fa-heart"></i></i></a></li>
                <li><a href="../cart.php" title="Cart"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="../profile.php" title="Profile"><i class="fa-solid fa-user"></i></a></li>
                <li><a  href="?logout" name='logout' title="Log Out"><i class="fa-solid fa-arrow-right-from-bracket"></i></i></a></li>
            </ul>
        </nav> 
    </div>

    <div class="payment-container" >
        <div class="header" >Admin - Admins</div>
        <div class="add-box" onclick="adminAddform('show')">
            <i  style="font-size: 100px;" class="fa-solid fa-user-plus"></i>
            <h5>Add New Admin</h5>
        </div>
        <form id="admin-add-form" method="post">
            <fieldset>
                <legend><b>Add New Admin</b></legend>
                <input type="text" name="adminFirstName" placeholder="Admin First Name" required>
                <input type="text" name="adminLastName" placeholder="Admin Last Name" required>
                <input type="emal" name="email" placeholder="Email" required>
                <input type="text" name="mobile" placeholder="Mobile " required>
                <input type="text" name="password" placeholder="Password" required>
                <input type="text" name="confirmPassword" placeholder="Confirm Password" required>
                
                <input  name="addAdminBtn"  class="home-btn" type="submit" value="Add Admin" >
                <br>
                <i style="font-size: 30px;color: red;"  class="fa-solid fa-circle-xmark" onclick="adminAddform('hide')"></i>
            </fieldset>
        </form>
        
        

    <?php
    if(mysqli_num_rows($users) > 0){
    ?>
    <form action="" style="width: 90%;" method="post">
        <fieldset class="order-container " >
            <legend><b>All Admins</b></legend>
            <div class="order-row" >
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Delivered Orders</th>
                        <th>Pending Orders</th>
                        <th>Admin Option</th>
                    </tr>
                    <?php
                    while($user = mysqli_fetch_assoc($users)){
                    ?>
                    <tr style="font-size: 13px;">
                        <td><?php echo $user['firstName'].' '.$user['lastName']?></td>
                        <td><?php echo $user['email'] ?></td>
                        <td><?php echo $user['mobile'] ?></td>
                        <td>10</td>
                        <td>2</td>
                        <td><input style="font-size: 12px; width: 80%;" name="deleteAdminBtn" type="submit" value="Delete Admin" class="home-btn admin-btn" ></td>
                    </tr> 
                    <?php
                    }
                    ?>           
                </table>
            </div>
        </fieldset>
    </form>
    <?php
    }
    ?>
    
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
    
    


    <script>

        function adminAddform(input) {
            let adminAddForm = document.getElementById('admin-add-form');
            if (input === 'show') {
                adminAddForm .style.display = 'block';
            } else if(input === 'hide'){
                adminAddForm.style.display = 'none';
            }
        }
    
    </script>

</body>
</html>
