<?php
session_start();
include 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo 'User not logged in.';
    exit();
}

if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $product_id = intval($_GET['product_id']);
    $quantity = intval($_GET['quantity']);
    $user_id = $_SESSION['user_id'];

    if ($quantity > 0) {
        $sql = "UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'Failed to update quantity';
        }
        $stmt->close();
    } else {
        echo 'Invalid quantity';
    }
} else {
    echo 'Invalid request';
}

$conn->close();
?>