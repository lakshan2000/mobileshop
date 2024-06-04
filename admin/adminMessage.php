<?php
include_once '../database/connection.php';

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];


    if(isset($_GET['logout'])){
        session_destroy();
        header("Location: ../homepage.php");
        exit(); 
    }


    
    $msgsSql = "SELECT * FROM messages";
    $msgs = mysqli_query($connect, $msgsSql);
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
                <li><a  href="?logout"  title="Log Out"><i class="fa-solid fa-arrow-right-from-bracket"></i></i></a></li>
            </ul>
        </nav> 
    </div>

    <div class="payment-container" >
        <div class="header" style="margin-bottom: 0;" >Admin - Messages</div>
        <?php
        if(mysqli_num_rows($msgs) > 0){
        ?>
        <form  action="">
        <div class="admin-msg-container">
            <?php
            while($msg = mysqli_fetch_assoc($msgs)){
            ?>
            <div class="msg-container">
                <div class="msg-details">
                    <p>From : <?php echo $msg['email'] ?></p>
                    <p>Date : <?php echo $msg['date'] ?></p>
                    <br>
                    <div class="msg-content">
                        <p><?php echo $msg['body'] ?></p>
                        <input type="button" value="Reply" class="home-btn" style="width: 15%;margin-left: 85%;margin-top: 2vh;" onclick="replyBox(<?php echo $msg['id'] ?>)" >
                    </div>
                </div>
                <div class="reply-box" id="reply-box<?php echo $msg['id'] ?>">
                    <p>To :  <?php echo $msg['email'] ?></p><br>
                    <form action="" method="get">
                        <textarea name="replyBody" id="" class="replyMsgBox" placeholder="Reply Message..." ></textarea>
                        <button type="submit" name="sendbtn" class="home-btn" style="width: 20vw;" >Send Reply</button>
                    </form>
                    <br>


                    <?php
                    if(isset($_GET['sendbtn'])){
                        $recipientEmail= $msg['email'];
                        $encodedSubject = rawurlencode('Reply: from mobileHub');
                        $replyBody = $_GET['replyBody'];
                        $encodedBody = rawurlencode($replyBody);
                        
                        header("Location: mailto:$recipientEmail?subject=$encodedSubject&body=$encodedBody");
                        exit(); 
                    }
                    ?>
                     
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        </form>
        <?php
        }else{
        ?>
        <div class="empty-box">
            <h1>Not Any Messages!!!</h1>
        </div>
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
        function replyBox(input){
            let replyBox = document.getElementById(`reply-box${input}`);
            if(replyBox.style.display ==='block'){
                replyBox.style.display ='none';
            }else if(replyBox.style.display ='none'){
                replyBox.style.display ='block';
            }
        }
    </script>


    

</body>
</html>
