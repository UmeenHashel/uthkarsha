<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin_navbar.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="navbar-brand">
                <a href="admin_dashboard.php">Admin Dashboard</a>
            </div>
            <div class="navbar-links">
                <ul>
                    <li><a href="user_management.php">User Management</a></li>
                    <li><a href="product_management.php">Product Management</a></li>
                    <li><a href="order_management.php">Order Management</a></li>
                    <li><a href="faq_management.php">FAQ Management</a></li>
                    <li><a href="#" id="logout-link">Logout</a></li>
                </ul>
            </div>
        </nav>
        <script>
            document.getElementById('logout-link').addEventListener('click', function(event) {
                event.preventDefault();
                if (confirm('Are you sure you want to log out?')) {
                    // Clear browser history and navigate to logout
                    window.location.href = 'logout.php';
                    history.pushState(null, null, 'login.php');
                    window.addEventListener('popstate', function(event) {
                        history.pushState(null, null, 'login.php');
                    });
                }
            });
        </script>
    </header>
</body>
</html>
