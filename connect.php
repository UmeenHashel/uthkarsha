<?php
$servername = "localhost";
$username = "root";
$password = "Rathnayake@602487";  
$dbname = "uthkarsha";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
