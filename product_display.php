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
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <main>
        <h1>All Products Available</h1>
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
                    echo '<a href="add_to_cart.php?id='.$row["product_id"].'" class="btn">Add to Cart</a>';
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
</body>
</html>
