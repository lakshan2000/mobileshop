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
    

    <?php
        include_once '../components/footer.php';
    ?> 
    
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
