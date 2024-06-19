<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/user_dashboard.css">
</head>

<body>


    <div class="sidebar">
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Orders</a></li>
            <li><a href="#">Messages</a></li>
            <li><a href="#">Account</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 id="welcome">Welcome, User!</h1>
        <div class="cards">
            <div class="card">
                <h2><a href="profile.php">Profile</a></h2>
                <p>View and edit your profile details.</p>
            </div>
            <div class="card">
                <h2>Orders</h2>
                <p>Check your recent orders and status.</p>
            </div>
            <div class="card">
                <h2>Messages</h2>
                <p>View your messages and notifications.</p>
            </div>
            <div class="card">
                <h2>Settings</h2>
                <p>Manage your account settings and preferences.</p>
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