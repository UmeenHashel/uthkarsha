<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    echo 'not_logged_in';
    exit();
}

$user_id = $_SESSION['user_id'];

$conn->begin_transaction();

try {
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

    $conn->commit();

    echo 'success';
} catch (Exception $e) {
    $conn->rollback();
    echo 'error: ' . $e->getMessage();
}

$conn->close();
?>