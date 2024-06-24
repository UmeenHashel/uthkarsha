<?php
session_start();
include 'connect.php'; 

// Check if the product ID is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details from the database
    $stmt = $conn->prepare("SELECT name, description, price, image_url, category, stock FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "Product ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/product_details.css">
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <main>
        <div class="product-card">
            <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
            <div class="product-info">
                <h1><?php echo $product['name']; ?></h1>
                <p class="price">$<?php echo $product['price']; ?></p>
                <p class="description"><?php echo $product['description']; ?></p>
                <p class="category">Category: <?php echo ucfirst($product['category']); ?></p>
                <p class="stock">Stock: <?php echo $product['stock']; ?></p>
                <a href="add_to_cart.php?id=<?php echo $product_id; ?>" class="btn">Add to Cart</a>
            </div>
        </div>
    </main>
</body>
</html>

<?php
$conn->close();
?>
