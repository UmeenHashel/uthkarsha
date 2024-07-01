<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'connect.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT o.order_id, o.order_date, o.total, oi.quantity, oi.price, p.name 
        FROM orders o
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN products p ON oi.product_id = p.product_id
        WHERE o.user_id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $order_id = $row['order_id'];
        if (!isset($orders[$order_id])) {
            $orders[$order_id] = [
                'order_id' => $order_id,
                'order_date' => $row['order_date'],
                'total' => $row['total'],
                'items' => []
            ];
        }
        $orders[$order_id]['items'][] = [
            'name' => $row['name'],
            'quantity' => $row['quantity'],
            'price' => $row['price']
        ];
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="css/order_history.css">
</head>

<body>
    <div class="container">
        <h1>Order History</h1>
        <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
        <div class="order">
            <div class="order-header">
                <span><strong>Order ID:</strong> <?php echo $order['order_id']; ?></span>
                <span><strong>Date:</strong> <?php echo $order['order_date']; ?></span>
                <span><strong>Total:</strong> Rs.<?php echo $order['total']; ?></span>
            </div>
            <div class="order-items">
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>Rs.<?php echo $item['price']; ?></td>
                            <td>Rs.<?php echo $item['quantity'] * $item['price']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>No orders found</p>
        <?php endif; ?>
    </div>
</body>

</html>
