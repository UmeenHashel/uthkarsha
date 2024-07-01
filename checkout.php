<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    echo 'error';
    exit();
}

$user_id = $_SESSION['user_id'];

// Start transaction
$conn->begin_transaction();

try {
    // Create new order
    $order_date = date('Y-m-d H:i:s');
    $status = 'Pending';

    $sql = "INSERT INTO orders (user_id, order_date, status, total) VALUES (?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $order_date, $status);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Fetch cart items for the logged-in user
    $sql = "SELECT product_id, quantity, price FROM cart_items WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_amount = 0;
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $total_amount += $price * $quantity;

        // Insert order items
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt_item = $conn->prepare($sql);
        $stmt_item->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        $stmt_item->execute();
        $stmt_item->close();
    }
    $stmt->close();

    // Update order total
    $sql = "UPDATE orders SET total = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $total_amount, $order_id);
    $stmt->execute();
    $stmt->close();

    // Clear cart
    $sql = "DELETE FROM cart_items WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Commit transaction
    $conn->commit();
    echo 'success';
} catch (Exception $e) {
    $conn->rollback();
    echo 'error';
}

$conn->close();
?>