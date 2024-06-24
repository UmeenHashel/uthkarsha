<?php
session_start();
include 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt_admin = $conn->prepare("SELECT admin_id, username FROM admin WHERE username = ? AND password = ?");
    $stmt_admin->bind_param("ss", $username, $password);
    $stmt_admin->execute();
    $stmt_admin->store_result();

    $stmt_user = $conn->prepare("SELECT user_id, username FROM users WHERE username = ? AND password = ?");
    $stmt_user->bind_param("ss", $username, $password);
    $stmt_user->execute();
    $stmt_user->store_result();

    if ($stmt_admin->num_rows > 0) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["usertype"] = "admin";

        header("location: admin_dashboard.php");
    } elseif ($stmt_user->num_rows > 0) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["usertype"] = "user";

        header("location: user_dashboard.php");
    } else {
        echo "The username or password you entered is incorrect.";
    }

    $stmt_admin->close();
    $stmt_user->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
