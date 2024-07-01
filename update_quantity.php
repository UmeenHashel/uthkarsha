<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    echo 'not_logged_in';
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'];
$quantity = $_GET['quantity'];

if ($quantity < 1 || $quantity > 99) {
    echo 'invalid_quantity';
    exit();
}

// Update cart item quantity
$sql = "UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $quantity, $user_id, $product_id);

if ($stmt->execute()) {
    echo 'success';
} else {
    echo 'error';
}

$stmt->close();
$conn->close();
?>