<?php
include 'connect.php';

$userId = 1; // You can change this to fetch different user or get it dynamically

$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $user = $result->fetch_assoc();
} else {
    echo "0 results";
}
$conn->close();
?>