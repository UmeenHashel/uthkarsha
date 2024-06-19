<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/cart.css">
    <style>
    /* Reset default margin and padding */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #f0f0f0;
        padding: 10px 20px;
        border-bottom: 1px solid #ddd;
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
    }

    .item-image {
        width: 150px;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .item-image img {
        width: 100%;
        border-radius: 4px;
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
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .actions button:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5>Cart</h5>
            </div>
            <div class="card-body">
                <!-- Single item -->
                <div class="item">
                    <div class="item-image">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Vertical/12a.webp"
                            alt="Blue Jeans Jacket">
                    </div>
                    <div class="item-details">
                        <p><strong>Blue denim shirt</strong></p>
                        <p>Color: Blue</p>
                        <p>Size: M</p>
                        <div class="actions">
                            <button type="button">Remove</button>

                        </div>
                    </div>
                    <div class="item-price">$17.99</div>
                </div>
                <!-- Single item -->
                <hr>
                <!-- Single item -->
                <div class="item">
                    <div class="item-image">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Vertical/13a.webp"
                            alt="Red Hoodie">
                    </div>
                    <div class="item-details">
                        <p><strong>Red hoodie</strong></p>
                        <p>Color: Red</p>
                        <p>Size: M</p>
                        <div class="actions">
                            <button type="button">Remove</button>
                        </div>
                    </div>
                    <div class="item-price">$17.99</div>
                </div>
                <!-- Single item -->
            </div>
        </div>
        <!-- Summary section -->
        <div class="card">
            <div class="card-body">

                <hr>
                <ul>
                    <li class="d-flex justify-content-between border-bottom pb-2">
                        <strong>Total amount </strong>
                        <strong>$35.98</strong>
                    </li>
                </ul>
                <button type="button" class="btn btn-primary btn-block">Go to checkout</button>
            </div>
        </div>
    </div>
</body>

</html>