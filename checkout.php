<?php
session_start();
include 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo 'not_logged_in';
    exit();
}

$user_id = $_SESSION['user_id'];

// Start a transaction
$conn->begin_transaction();

try {
    // Create a new order
    $sql = "INSERT INTO orders (user_id, order_date, status, total) VALUES (?, NOW(), 'Pending', 0)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Prepare statement failed: ' . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Fetch cart items for the logged-in user
    $sql = "SELECT cart_items.product_id, cart_items.quantity, products.price 
            FROM cart_items 
            JOIN products ON cart_items.product_id = products.product_id 
            WHERE cart_items.user_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Prepare statement failed: ' . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }
    $result = $stmt->get_result();
    $cart_items = [];
    $total = 0;

    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
        $total += $row['price'] * $row['quantity'];
    }
    $stmt->close();

    // Insert cart items into order_items
    $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Prepare statement failed: ' . $conn->error);
    }

    foreach ($cart_items as $item) {
        $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        if (!$stmt->execute()) {
            throw new Exception('Execute failed: ' . $stmt->error);
        }
    }
    $stmt->close();

    // Update the total in the orders table
    $sql = "UPDATE orders SET total = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Prepare statement failed: ' . $conn->error);
    }
    $stmt->bind_param("di", $total, $order_id);
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }
    $stmt->close();

    // Clear the cart
    $sql = "DELETE FROM cart_items WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Prepare statement failed: ' . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }
    $stmt->close();

    // Commit the transaction
    $conn->commit();

    echo 'success';
} catch (Exception $e) {
    $conn->rollback();
    echo 'error: ' . $e->getMessage();
}

$conn->close();
?>