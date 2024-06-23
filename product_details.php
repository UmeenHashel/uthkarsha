<?php
// Check if product ID is provided in the URL
if (!isset($_GET['product_id'])) {
    // Redirect to product display page if ID is not provided
    header("Location: product_display.php");
    exit();
}

include 'connect.php';

// Initialize variables to store product details
$product_name = "";
$product_description = "";
$product_price = 0;
$product_image = "";
$product_category = "";
$product_stock = 0;

// Prepare SQL statement to fetch product details based on ID
$product_id = intval($_GET['product_id']); // Ensure product_id is an integer
$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch product details
    $row = $result->fetch_assoc();
    $product_name = $row['name'];
    $product_description = $row['description'];
    $product_price = $row['price'];
    $product_image = $row['image_url'];
    $product_category = $row['category'];
    $product_stock = $row['stock'];
} else {
    // Redirect to product display page if product not found
    header("Location: product_display.php");
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product_name); ?> - Product Details</title>
    <link rel="stylesheet" href="css/product_display.css">
    <style>
    /* Additional styles specific to product_detail.php */
    .product-details {
        display: flex;
        align-items: flex-start;
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .product-details img {
        max-width: 300px;
        border-radius: 8px;
        margin-right: 20px;
    }

    .product-info {
        flex: 1;
    }

    .product-info h2 {
        color: #333;
        margin-bottom: 10px;
    }

    .product-info .price {
        color: #007bff;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .product-info p {
        color: #555;
        line-height: 1.6;
    }

    .add-to-cart-btn {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
        transition: background-color 0.3s;
    }

    .add-to-cart-btn:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <main>
        <div class="product-details">
            <img src="<?php echo htmlspecialchars($product_image); ?>" alt="<?php echo htmlspecialchars($product_name); ?> Image">
            <div class="product-info">
                <h2><?php echo htmlspecialchars($product_name); ?></h2>
                <p class="price">Rs.<?php echo htmlspecialchars($product_price); ?></p>
                <p><?php echo nl2br(htmlspecialchars($product_description)); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($product_category); ?></p>
                <p><strong>Stock:</strong> <?php echo htmlspecialchars($product_stock); ?></p>
                <a href="#" class="add-to-cart-btn">Add to Cart</a>
            </div>
        </div>
    </main>
</body>

</html>
