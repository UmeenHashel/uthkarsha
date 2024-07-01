<?php
session_start();
include 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = 1; // Default quantity

// Debug: Check the received product_id
echo "Received product_id: " . $product_id . "<br>";

if ($product_id > 0) {
    // Insert into cart_items table
    $sql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        if ($stmt->execute()) {
            // Redirect to cart page or show a success message
            header("Location: cart.php?status=success");
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid product ID";
}

$conn->close();
?>
