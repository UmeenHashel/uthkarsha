<?php
session_start();
include 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$sql = "SELECT products.product_id, products.name, products.image_url, products.price, cart_items.quantity 
        FROM cart_items 
        JOIN products ON cart_items.product_id = products.product_id 
        WHERE cart_items.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}

$stmt->close();
$conn->close();

function calculateTotal($cartItems) {
    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/cart.css">
</head>

<body>
    <div class="navcontact">
        <?php include 'navbar.php'; ?>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5>Shopping Cart</h5>
            </div>
            <div class="card-body">
                <?php if (count($cart_items) > 0): ?>
                <?php foreach ($cart_items as $item): ?>
                <div class="item">
                    <div class="item-image">
                        <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>">
                    </div>
                    <div class="item-details">
                        <p><strong><?= $item['name'] ?></strong></p>
                        <p>Price: Rs.<?= number_format($item['price'], 2) ?></p>
                        <div class="quantity">
                            <button class="quantity-btn" data-action="decrease"
                                data-product-id="<?= $item['product_id'] ?>">-</button>
                            <input type="number" class="quantity-input" data-product-id="<?= $item['product_id'] ?>"
                                value="<?= $item['quantity'] ?>" min="1" max="99" readonly>
                            <button class="quantity-btn" data-action="increase"
                                data-product-id="<?= $item['product_id'] ?>">+</button>
                        </div>
                        <div class="actions">
                            <button type="button" class="remove-btn"
                                data-product-id="<?= $item['product_id'] ?>">Remove</button>
                        </div>
                    </div>
<<<<<<< Updated upstream
                    <div class="item-price" id="item-price-<?= $item['product_id'] ?>">Total: Rs.<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
=======
                    <div class="item-price" id="item-price-<?= $item['product_id'] ?>">Total:
                        Rs.<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
>>>>>>> Stashed changes
                </div>
                <?php endforeach; ?>
                <div class="checkout">
                    <div class="total">
                        <strong>Total amount: Rs.<?= number_format(calculateTotal($cart_items), 2) ?></strong>
                    </div>
                    <button type="button" class="btn checkout-btn">Go to checkout</button>
                </div>
                <?php else: ?>
                <div class="empty-cart">
                    <p>Your cart is empty.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityButtons = document.querySelectorAll('.quantity-btn');
        const totalAmountElement = document.querySelector('.total strong');

<<<<<<< Updated upstream
       
       // Function to update quantity on server and in UI
=======

        // Function to update quantity on server and in UI
>>>>>>> Stashed changes
        function updateQuantity(productId, newQuantity) {
            fetch(`update_quantity.php?product_id=${productId}&quantity=${newQuantity}`, {
                method: 'GET'
            }).then(response => response.text()).then(data => {
                if (data === 'success') {
                    // Update quantity in the UI
<<<<<<< Updated upstream
                    const inputToUpdate = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
=======
                    const inputToUpdate = document.querySelector(
                        `.quantity-input[data-product-id="${productId}"]`);
>>>>>>> Stashed changes
                    inputToUpdate.value = newQuantity;
                    // Update item price in the UI
                    const itemPrice = parseFloat(inputToUpdate.getAttribute('data-price'));
                    const itemPriceElement = document.querySelector(`#item-price-${productId}`);
                    itemPriceElement.textContent = `Total: Rs.${(itemPrice * newQuantity).toFixed(2)}`;
                    // Recalculate total amount after updating quantity
                    recalculateTotal();
                    // Reload the page
                    location.reload();
                } else {
                    alert('Failed to update quantity');
                }
            });
        }


        // Function to recalculate total amount
        function recalculateTotal() {
            fetch('fetch_cart_items.php')
                .then(response => response.json())
                .then(data => {
                    const totalAmount = data.reduce((acc, item) => acc + (item.price * item.quantity), 0);
                    totalAmountElement.textContent = 'Total amount: Rs.' + totalAmount.toFixed(2);
                });
        }

        // Attach event listeners to quantity buttons
        quantityButtons.forEach(button => {
            button.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const productId = this.getAttribute('data-product-id');
<<<<<<< Updated upstream
                const inputElement = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
=======
                const inputElement = document.querySelector(
                    `.quantity-input[data-product-id="${productId}"]`);
>>>>>>> Stashed changes
                let currentQuantity = parseInt(inputElement.value);

                if (action === 'increase' && currentQuantity < 99) {
                    currentQuantity++;
                } else if (action === 'decrease' && currentQuantity > 1) {
                    currentQuantity--;
                }

                updateQuantity(productId, currentQuantity);
            });
        });

        // Attach event listeners to remove buttons
        const removeButtons = document.querySelectorAll('.remove-btn');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                fetch(`remove_from_cart.php?product_id=${productId}`, {
                    method: 'GET'
                }).then(response => response.text()).then(data => {
                    if (data === 'success') {
                        // Remove the item from the UI
                        const itemElement = this.closest('.item');
                        itemElement.remove();
                        // Recalculate total amount after item removal
                        recalculateTotal();
                    } else {
                        alert('Failed to remove item');
                    }
                });
            });
        });
    });
<<<<<<< Updated upstream
</script>
=======
    </script>
>>>>>>> Stashed changes

</body>

</html>