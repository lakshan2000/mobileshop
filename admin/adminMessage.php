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
                <li><a href="admindahsbord.html">Admin</a></li>
                <li><a href="../homepage.html">Home</a></li>
                <li><a href="../shop.html">Shop</a></li>                
                <li><a href="../wishlist.html" title="Wish_list"><i class="fa-solid fa-heart"></i></i></a></li>
                <li><a href="../cart.html" title="Cart"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="../profile.html" title="Profile"><i class="fa-solid fa-user"></i></a></li>
                <li><a href="../homepage.html" title="Log Out"><i class="fa-solid fa-arrow-right-from-bracket"></i></i></a></li>
                <!-- <li><a href="login.html">Login</a></li>
                <li><a href="register.html">Register</a></li> -->
            </ul>
        </nav> 
    </div>

    <div class="payment-container" >
        <div class="header" style="margin-bottom: 0;" >Admin - Messages</div>
        <form  action="">
        <div class="admin-msg-container">
            <div class="msg-container">
                <div class="msg-details">
                    <p>From : lakshan@gmail.com</p>
                    <p>Date : 2024.11.23</p>
                    <br>
                    <div class="msg-content">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Odit fugit atque illum doloremque velit dolor, ea dolore eaque adipisci nulla maxime molestiae dolorum! Assumenda quo rerum eius dolor consectetur, minima similique sit ab voluptatum alias animi aut itaque, nihil est voluptate optio sapiente! Quisquam tenetur ipsum rerum reprehenderit, quae sunt!</p>
                        <input type="button" value="Reply" class="home-btn" style="width: 15%;margin-left: 85%;margin-top: 2vh;" onclick="replyBox(1)" >
                    </div>
                </div>
                <div class="reply-box" id="reply-box1">
                    <p>To : lakshan@gmail.com</p><br>
                    <textarea name="" id="" class="replyMsgBox" placeholder="Reply Message..." ></textarea><br>
                     <input class="home-btn" style="width: 20vw;" type="button" value="Send Reply">
                </div>
            </div>
            <div class="msg-container">
                <div class="msg-details">
                    <p>From : lakshan@gmail.com</p>
                    <p>Date : 2024.11.23</p>
                    <br>
                    <div class="msg-content">
                        <p >Lorem, ipsum dolor sit amet consectetur adipisicing elit. Odit fugit atque illum doloremque velit dolor, ea dolore eaque adipisci nulla maxime molestiae dolorum! Assumenda quo rerum eius dolor consectetur, minima similique sit ab voluptatum alias animi aut itaque, nihil est voluptate optio sapiente! Quisquam tenetur ipsum rerum reprehenderit, quae sunt!</p>
                        <input type="button" value="Reply" class="home-btn" style="width: 15%;margin-left: 85%;margin-top: 2vh;" onclick="replyBox(2)" >
                    </div>
                </div>
                <div class="reply-box" id="reply-box2">
                    <p>To : lakshan@gmail.com</p><br>
                    <textarea name="" id="" class="replyMsgBox" placeholder="Reply Message..." ></textarea><br>
                     <input class="home-btn" style="width: 20vw;" type="button" value="Send Reply">
                </div>
            </div>
        </div>
        </form>


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
