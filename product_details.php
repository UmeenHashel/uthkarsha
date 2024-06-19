<?php
// Check if product ID is provided in the URL
if (!isset($_GET['id'])) {
    // Redirect to product display page if ID is not provided
    header("Location: product_display.php");
    exit();
}

// Replace with your database connection details
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to store product details
$product_name = "";
$product_description = "";
$product_price = 0;
$product_image = "";

// Prepare SQL statement to fetch product details based on ID
$product_id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch product details
    $row = $result->fetch_assoc();
    $product_name = $row['name'];
    $product_description = $row['description'];
    $product_price = $row['price'];
    $product_image = $row['image_path'];
} else {
    // Redirect to product display page if product not found
    header("Location: product_display.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product_name; ?> - Product Details</title>
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

    <main>
        <div class="product-details">
            <img src="<?php echo $product_image; ?>" alt="<?php echo $product_name; ?> Image">
            <div class="product-info">
                <h2><?php echo $product_name; ?></h2>
                <p class="price">$<?php echo $product_price; ?></p>
                <p><?php echo $product_description; ?></p>
                <a href="#" class="add-to-cart-btn">Add to Cart</a>
            </div>
        </div>
    </main>
</body>

</html>