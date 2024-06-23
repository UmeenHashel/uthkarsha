<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/user_dashboard.css">
</head>

<body>
    <div class="nav_profile">
        <?php include 'navbar.php'; ?>
    </div>
    <break>
        <div class="content">
            <h1 id="welcome">Welcome, User!</h1>
            <div class="cards">
                <div class="card">
                    <h2><a href="profile.php">Profile</a></h2>
                    <p>View and edit your profile details.</p>

                </div>
                <div class="card">
                    <a href="order_history.php">
                        <h2>Orders</h2>
                    </a>
                    <p>Check your recent orders and status.</p>
                </div>
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