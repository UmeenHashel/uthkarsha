<?php
include '../connect.php';

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Function to validate image
function validate_image($file) {
    $errors = [];
    $allowed_mime_types = ['image/png'];
    $max_width = 600;
    $max_height = 600;

    $image_info = getimagesize($file['tmp_name']);
    if ($image_info === false) {
        $errors[] = "The file is not a valid image.";
    } else {
        if (!in_array($image_info['mime'], $allowed_mime_types)) {
            $errors[] = "Only PNG images are allowed.";
        }
        if ($image_info[0] != $max_width || $image_info[1] != $max_height) {
            $errors[] = "Image dimensions must be 600x600 pixels.";
        }
    }

    return $errors;
}

$errors = [];

// Add product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    // Check for existing product
    $product_check_sql = "SELECT * FROM products WHERE name='$name' AND category='$category'";
    $product_check_result = $conn->query($product_check_sql);
    if ($product_check_result->num_rows > 0) {
        $errors[] = "A product with the same name and category already exists.";
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_errors = validate_image($_FILES['image']);
        if (empty($image_errors)) {
            $image_path = 'db_images/' . basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image_path)) {
                if (empty($errors)) {
                    $sql = "INSERT INTO products (name, description, price, image_url, category, stock) VALUES ('$name', '$description', '$price', '$image_path', '$category', '$stock')";
                    $conn->query($sql);
                }
            } else {
                $errors[] = "Failed to move uploaded file.";
            }
        } else {
            $errors = array_merge($errors, $image_errors);
        }
    } else {
        $errors[] = "Please upload an image.";
    }
}

// Delete product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    $sql = "DELETE FROM products WHERE product_id='$product_id'";
    $conn->query($sql);
}

// Update product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    // Check for existing product
    $product_check_sql = "SELECT * FROM products WHERE name='$name' AND category='$category' AND product_id != '$product_id'";
    $product_check_result = $conn->query($product_check_sql);
    if ($product_check_result->num_rows > 0) {
        $errors[] = "A product with the same name and category already exists.";
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_errors = validate_image($_FILES['image']);
        if (empty($image_errors)) {
            $image_path = 'db_images/' . basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image_path)) {
                if (empty($errors)) {
                    $sql = "UPDATE products SET name='$name', description='$description', price='$price', image_url='$image_path', category='$category', stock='$stock' WHERE product_id='$product_id'";
                    $conn->query($sql);
                }
            } else {
                $errors[] = "Failed to move uploaded file.";
            }
        } else {
            $errors = array_merge($errors, $image_errors);
        }
    } else {
        if (empty($errors)) {
            $sql = "UPDATE products SET name='$name', description='$description', price='$price', category='$category', stock='$stock' WHERE product_id='$product_id'";
            $conn->query($sql);
        }
    }
}

// Fetch products
$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management - Admin</title>
    <link rel="stylesheet" href="../css/admin_navbar.css">
    <link rel="stylesheet" href="../css/product_management.css">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>

    <h1>Product Management</h1>

    <form action="product_management.php" method="POST" enctype="multipart/form-data" class="product-form">
        <input type="hidden" name="product_id" id="product_id">
        <input type="text" name="name" id="name" placeholder="Product Name" required>
        <textarea name="description" id="description" placeholder="Description"></textarea>
        <input type="number" step="0.01" name="price" id="price" placeholder="Price" required>
        <input type="file" name="image" id="image" accept="image/png" required>
        <select name="category" id="category" required>
            <option value="men">Men</option>
            <option value="women">Women</option>
        </select>
        <input type="number" name="stock" id="stock" placeholder="Stock" required>
        <button type="submit" name="add_product">Add Product</button>
        <button type="submit" name="update_product">Update Product</button>
    </form>

    <?php if (!empty($errors)) { ?>
        <div class="error-messages">
            <?php foreach ($errors as $error) { ?>
                <p><?php echo $error; ?></p>
            <?php } ?>
        </div>
    <?php } ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $products->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $product['product_id']; ?></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo $product['description']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td><img src="<?php echo '../'.$product['image_url']; ?>" alt="<?php echo $product['name']; ?>"></td>
                <td><?php echo $product['category']; ?></td>
                <td><?php echo $product['stock']; ?></td>
                <td>
                    <button onclick="editProduct(<?php echo $product['product_id']; ?>, '<?php echo $product['name']; ?>', '<?php echo $product['description']; ?>', '<?php echo $product['price']; ?>', '<?php echo $product['image_url']; ?>', '<?php echo $product['category']; ?>', '<?php echo $product['stock']; ?>')">Edit</button>
                    <form action="product_management.php" method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <button type="submit" name="delete_product">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        function editProduct(id, name, description, price, imageUrl, category, stock) {
            document.getElementById('product_id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('description').value = description;
            document.getElementById('price').value = price;
            document.getElementById('image_url').value = imageUrl;
            document.getElementById('category').value = category;
            document.getElementById('stock').value = stock;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
