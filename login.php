<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user is an admin
    $stmt_admin = $conn->prepare("SELECT admin_id, username, password FROM admin WHERE username = ?");
    $stmt_admin->bind_param("s", $username);
    $stmt_admin->execute();
    $stmt_admin->store_result();
    $stmt_admin->bind_result($admin_id, $admin_username, $admin_password);

    // Check if the user is a normal user
    $stmt_user = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt_user->bind_param("s", $username);
    $stmt_user->execute();
    $stmt_user->store_result();
    $stmt_user->bind_result($user_id, $user_username, $user_password);

    if ($stmt_admin->num_rows > 0) {
        $stmt_admin->fetch();
        if (password_verify($password, $admin_password)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $admin_username;
            $_SESSION["usertype"] = "admin";
            $_SESSION["user_id"] = $admin_id;  // Set the user_id in the session
            header("location: admin_dashboard.php");
            exit();
        } else {
            $login_error = "The username or password you entered is incorrect.";
        }
    } elseif ($stmt_user->num_rows > 0) {
        $stmt_user->fetch();
        if (password_verify($password, $user_password)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $user_username;
            $_SESSION["usertype"] = "user";
            $_SESSION["user_id"] = $user_id;  // Set the user_id in the session
            header("location: user_dashboard.php");
            exit();
        } else {
            $login_error = "The username or password you entered is incorrect.";
        }
    } else {
        $login_error = "The username or password you entered is incorrect.";
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
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <div class="login-page">
        <div class="login-container">
            <h2>Login</h2>
            <?php 
            if (isset($login_error)) {
                echo '<p class="error">'.$login_error.'</p>';
            }
            ?>
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
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>