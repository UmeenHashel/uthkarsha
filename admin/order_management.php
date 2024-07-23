<?php
include '../connect.php';

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Update order status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $sql = "UPDATE orders SET status='$status' WHERE order_id='$order_id'";
    $conn->query($sql);
}

// Delete order
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];
    $sql = "DELETE FROM orders WHERE order_id='$order_id'";
    $conn->query($sql);
}

// Fetch order details
$sql = "SELECT o.order_id, o.order_date, o.status, u.first_name, u.last_name, p.name as product_name, p.image_url, oi.quantity, oi.price 
        FROM orders o 
        JOIN users u ON o.user_id = u.user_id 
        JOIN order_items oi ON o.order_id = oi.order_id 
        JOIN products p ON oi.product_id = p.product_id";
$orders = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Admin</title>
    <link rel="stylesheet" href="../css/admin_navbar.css">
    <link rel="stylesheet" href="../css/order_management.css">
</head>
<body>
    <header>
        <?php include 'admin_navbar.php'; ?>
    </header>
    <main>
        <h1>Order Management</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>User Name</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td><?php echo $order['first_name'] . ' ' . $order['last_name']; ?></td>
                    <td><?php echo $order['product_name']; ?></td>
                    <td><img src="<?php echo '../' . $order['image_url']; ?>" alt="<?php echo $order['product_name']; ?>"></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo $order['price']; ?></td>
                    <td>
                        <form action="order_management.php" method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <select name="status">
                                <option value="pending" <?php if($order['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                <option value="shipped" <?php if($order['status'] == 'shipped') echo 'selected'; ?>>Shipped</option>
                                <option value="delivered" <?php if($order['status'] == 'delivered') echo 'selected'; ?>>Delivered</option>
                                <option value="cancelled" <?php if($order['status'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                            </select>
                            <button type="submit" name="update_order">Update</button>
                        </form>
                    </td>
                    <td>
                        <form action="order_management.php" method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <button type="submit" name="delete_order">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>
</html>

<?php $conn->close(); ?>
