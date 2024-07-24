<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin_navbar.css">
    <link rel="stylesheet" href="../css/admin_dashboard.css">
</head>

<body>
    <?php include 'admin_navbar.php'; ?>

    <div class="content">
        <div class="card">
            <h1>Welcome to the Admin Dashboard</h1>
            <img src="../img/admin.png" alt="Admin Icon" class="admin-icon">
            <p>Welcome, Admin! This is your main hub for managing the system. Here you can oversee and manage various aspects of the website. Below is a brief overview of the functionalities available to you:</p>
            <h2>Admin Panel</h2>
            <p>As an administrator, you have the ability to:</p>
            <ul>
                <li><strong>Manage Users:</strong> Add, update, and delete user accounts. View user details and manage their information.</li>
                <li><strong>Manage Products:</strong> Add new products, update existing product details, and delete products from the inventory.</li>
                <li><strong>Manage Orders:</strong> View and manage customer orders. Update the status of orders and ensure timely fulfillment.</li>
                <li><strong>Update Order Status:</strong> Change the status of orders to keep users informed about their purchase progress.</li>
                <li><strong>View Sales Reports:</strong> Access detailed sales reports to monitor the performance of the store and make informed decisions.</li>
                <li><strong>Monitor System Activities:</strong> Keep an eye on system activities and ensure everything is running smoothly.</li>
            </ul>
        </div>
    </div>
</body>

</html>
