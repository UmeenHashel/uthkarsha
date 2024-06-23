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
                <span><strong>Total:</strong> $<?php echo $order['total_amount']; ?></span>
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
                            <td><?php echo $item['product_name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo $item['price']; ?></td>
                            <td>$<?php echo $item['quantity'] * $item['price']; ?></td>
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