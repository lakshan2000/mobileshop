<?php

session_start();

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "mobilehub_database"; 

$connect = mysqli_connect($servername, $username, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
    
}

?>
