<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTHKARSHA CLOTHING STORE</title>
    <link rel="stylesheet" href="css/navbar.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="navbar-brand">
                <a href="index.php">UTHKARSHA CLOTHING STORE</a>
            </div>
            <div class="navbar-links">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="product_display.php">Products</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="user_dashboard.php">Profile</a></li>
                    <li><a href="terms_conditions.php">Terms and Conditions</a></li>
                    <li><a href="privacy_policy.php">Privacy Policy</a></li>
                    <li><a href="faq.php">FAQs</a></li>
                    <li><a href="about_contact.php">About Us</a></li>

                </ul>
            </div>
        </nav>
        <script>
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = 'index.php';
            }
        });
        </script>
    </header>
</body>

</html>