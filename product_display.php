<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - UTHKARSHA CLOTHING STORE</title>
    <link rel="stylesheet" href="css/product_display.css">
</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <main>
        <h1>All clothing items available</h1>
        <div class="product-list">
            <?php
            include 'connect.php';
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-item">';
                    echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<div class="product-info">';
                    echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
                    echo '<p class="price">Rs.' . htmlspecialchars($row['price']) . '</p>';
                    echo '<a href="product_details.php?product_id=' . htmlspecialchars($row['product_id']) . '" class="btn">View Details</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No products found";
            }

            $conn->close();
            ?>
        </div>
    </main>
</body>

</html>
