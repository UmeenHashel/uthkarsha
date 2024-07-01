<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    echo 'not_logged_in';
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'];

// Delete cart item
$sql = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);

if ($stmt->execute()) {
    echo 'success';
} else {
    echo 'error';
}

$stmt->close();
$conn->close();
?>