<?php
session_start();
include 'connect.php'; 

$sql = "SELECT product_id, name, price, image_url FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Display</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/product_display.css">
    <script>
    function showAlert(message) {
        alert(message);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const message = urlParams.get('message');

        if (status === 'error' && message) {
            showAlert(message);
        }
    });
    </script>
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <main>
        <h1>All Products Available</h1>
        <?php
        if (isset($_GET['status']) && $_GET['status'] == 'success') {
            echo '<p class="success">Product added to cart successfully!</p>';
        }
        ?>
        <div class="product-list">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="product-card">';
                    echo '<img src="'.$row["image_url"].'" alt="'.$row["name"].'">';
                    echo '<div class="product-info">';
                    echo '<h2>'.$row["name"].'</h2>';
                    echo '<p class="price">Rs. '.$row["price"].'</p>';
                    echo '<a href="product_details.php?id='.$row["product_id"].'" class="btn">View Details</a>';
                    echo '<form action="add_to_cart.php" method="post">';
                    echo '<input type="hidden" name="product_id" value="'.$row["product_id"].'">';
                    echo '<button type="submit" class="btn">Add to Cart</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No products available.</p>';
            }
            $conn->close();
            ?>
        </div>
    </main>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
