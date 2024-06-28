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
    <style>
    /* Additional CSS for cart.php */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #f0f0f0;
        padding: 10px 20px;
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
    }

    .card-header h5 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: bold;
    }

    .card-body {
        padding: 20px;
    }

    .item {
        display: flex;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 20px;
    }

    .item-image {
        width: 150px;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .item-image img {
        width: 100%;
        border-radius: 4px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .item-details {
        flex-grow: 1;
    }

    .item-details p {
        margin-bottom: 8px;
    }

    .item-price {
        font-size: 1.2rem;
        font-weight: bold;
        text-align: right;
        flex-shrink: 0;
    }

    .quantity {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .quantity input {
        width: 40px;
        text-align: center;
        margin: 0 5px;
    }

    .quantity-btn {
        background-color: #04AA6D;
        border: none;
        color: white;
        padding: 5px 7px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }

    .actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 10px;
    }

    .actions button {
        margin-left: 10px;
        padding: 8px 16px;
        border: none;
        background-color: #dc3545;
        color: #fff;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .actions button:hover {
        background-color: #c82333;
    }

    .checkout {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .checkout .total {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .checkout .btn {
        padding: 10px 20px;
        border: none;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .checkout .btn:hover {
        background-color: #0056b3;
    }

    .empty-cart {
        text-align: center;
        margin-top: 20px;
        padding: 20px;
        background-color: #f0f0f0;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    </style>
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
                    <div class="item-price">Total: Rs.<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
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
    // JavaScript to handle quantity adjustment and removal of items
    document.addEventListener('DOMContentLoaded', function() {
                const quantityButtons = document.querySelectorAll('.quantity-btn');
                const totalAmountElement = document.querySelector('.total strong');

                // Function to update quantity on server and in UI
                function updateQuantity(productId, newQuantity) {
                    fetch(`update_quantity.php?product_id=${productId}&quantity=${newQuantity}`, {
                        method: 'GET'
                    }).then(response => response.text()).then(data => {
                        if (data === 'success') {
                            // Update quantity in the UI
                            const inputToUpdate = document.querySelector(
                                `.quantity-input[data-product-id="${productId}"]`);
                            inputToUpdate.value = newQuantity;
                            // Recalculate total amount
                            recalculateTotal();
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
                                        const product