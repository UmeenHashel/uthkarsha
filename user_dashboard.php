<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/user_dashboard.css">
</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <div class="content">
    <h1 id="welcome">Welcome, User!</h1>
        <div class="card">
            <h2>Profile</h2>
            <?php include 'profile.php'; ?>
        </div>
        <div class="card">
            <h2>Orders</h2>
            <?php include 'order_history.php'; ?>
        </div>
    </div>
        <script>
            // JavaScript to update the welcome message
            document.addEventListener('DOMContentLoaded', function() {
                const userName = userName; // You can replace this with dynamic data
                document.getElementById('welcome').innerText = `Welcome, ${userName}!`;
            });
        </script>
</body>

</html>