<?php
session_start();
include 'connect.php';

// Assuming you store the user ID in the session
/*
$user_id = $_SESSION['user_id'];
*/
$user_id = 2;
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
            <h1 id="username"><?php echo $user['username']; ?></h1>
            <p id="email"><?php echo $user['email']; ?></p>
        </div>


        <div class="profile-details">
            <h2>Profile Details</h2>
            <div class="detail">
                <span class="label">First Name:</span>
                <span class="value" id="first_name"><?php echo $user['first_name']; ?></span>
            </div>
            <div class="detail">
                <span class="label">Last Name:</span>
                <span class="value" id="last_name"><?php echo $user['last_name']; ?></span>
            </div>
            <div class="detail">
                <span class="label">Email:</span>
                <span class="value" id="email"><?php echo $user['email']; ?></span>
                <div class="detail">
                    <span class="label">Phone:</span>
                    <span class="value" id="phone"><?php echo $user['phone']; ?></span>
                </div></span>
            </div>

            <div class="detail">
                <span class="label">Address:</span>
                <span class="value" id="address"><?php echo $user['address']; ?></span>
            </div>
        </div>
    </div>
</body>

</html>