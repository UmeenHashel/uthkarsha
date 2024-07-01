<?php
session_start();
include 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Function to cancel an order
if (isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];
    
    // Delete order items first
    $sql_delete_items = "DELETE FROM order_items WHERE order_id = ?";
    $stmt_delete_items = $conn->prepare($sql_delete_items);
    $stmt_delete_items->bind_param("i", $order_id);
    if ($stmt_delete_items->execute()) {
        // Proceed to delete the order itself
        $sql_delete_order = "DELETE FROM orders WHERE order_id = ?";
        $stmt_delete_order = $conn->prepare($sql_delete_order);
        $stmt_delete_order->bind_param("i", $order_id);
        if ($stmt_delete_order->execute()) {
            $message = "Order canceled successfully.";
        } else {
            $error_message = "Failed to cancel order.";
        }
        $stmt_delete_order->close();
    } else {
        $error_message = "Failed to cancel order items.";
    }
    $stmt_delete_items->close();
}

// Fetch orders for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link rel="stylesheet" href="css/orders.css">

</head>

<body>
    <div class="navcontact">
        <?php include 'navbar.php'; ?>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5>Your Orders</h5>
            </div>
            <div class="card-body">
                <?php if (isset($message)): ?>
                <div class="message"><?= $message ?></div>
                <?php endif; ?>
                <?php if (isset($error_message)): ?>
                <div class="error-message"><?= $error_message ?></div>
                <?php endif; ?>
                <?php if (count($orders) > 0): ?>
                <ul>
                    <?php foreach ($orders as $order): ?>
                    <li>
                        <div>
                            <strong>Order ID:</strong> <?= $order['order_id'] ?><br>
                            <strong>Date:</strong> <?= $order['order_date'] ?><br>
                            <strong>Total:</strong> Rs.<?= number_format($order['total'], 2) ?><br>
                            <strong>Status:</strong> <?= $order['status'] ?><br>
                        </div>
                        <form method="POST" action="">
                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                            <button type="submit" class="cancel-btn" name="cancel_order">Cancel</button>
                        </form>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p>You have no orders.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>