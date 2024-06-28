<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'connect.php';

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    echo '<script>
            alert("User not logged in.");
            window.location.href = "index.php";
          </script>';
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <div class="container">
        <div class="profile-header">
            <img src="img/avatar.jpg" alt="User Avatar" class="avatar">
            <h1 id="username"><?php echo htmlspecialchars($user['username'] ?? ''); ?></h1>
            <p id="email"><?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
        </div>
        <div class="profile-details">
            <h2>Profile Details</h2>
            <div class="detail">
                <span class="label">First Name:</span>
                <span class="value" id="first_name"><?php echo htmlspecialchars($user['first_name'] ?? ''); ?></span>
            </div>
            <div class="detail">
                <span class="label">Last Name:</span>
                <span class="value" id="last_name"><?php echo htmlspecialchars($user['last_name'] ?? ''); ?></span>
            </div>
            <div class="detail">
                <span class="label">Email:</span>
                <span class="value" id="email"><?php echo htmlspecialchars($user['email'] ?? ''); ?></span>
            </div>
            <div class="detail">
                <span class="label">Phone:</span>
                <span class="value" id="phone"><?php echo htmlspecialchars($user['phone'] ?? ''); ?></span>
            </div>
            <div class="detail">
                <span class="label">Address:</span>
                <span class="value" id="address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></span>
            </div>
        </div>
    </div>
</body>

</html>