<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin_navbar.css">
</head>

<body>
    <?php include 'admin_navbar.php'; ?>

    <div class="content">
        <h1>Welcome to the Admin Dashboard</h1>
        <!-- Add your admin dashboard content here -->
    </div>
</body>

</html>
