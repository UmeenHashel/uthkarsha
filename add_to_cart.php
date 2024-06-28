<?php
session_start();
include 'connect.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: product_display.php?status=error&message=User not logged in.");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    
    // Check if the item is already in the cart
    $stmt = $conn->prepare("SELECT quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Item is already in the cart, update the quantity
        $stmt->bind_result($quantity);
        $stmt->fetch();
        $quantity++;
        $stmt->close();

        $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    } else {
        // Item is not in the cart, insert a new record
        $quantity = 1;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    }
    
    if ($stmt->execute()) {
        header("Location: product_display.php?status=success&product=".$product_id);
        exit();
    } else {
        header("Location: product_display.php?status=error&message=Error adding to cart: " . $conn->error);
        exit();
    }
    
    $stmt->close();
} else {
    header("Location: product_display.php?status=error&message=Product ID not provided.");
    exit();
}

$conn->close();
?>