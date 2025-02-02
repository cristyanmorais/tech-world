<?php
include('./database/connection.php');
require_once './components/header.php';

if (!isset($_SESSION['quantity'])) {
    $_SESSION['quantity'] = array();
}

$inIds = '';

if (isset($_COOKIE['cart'])) {
    $productIds = json_decode($_COOKIE['cart'], true);

    if (!empty($productIds)) {
        foreach ($productIds as $productId) {
            if (!isset($_SESSION['quantity'][$productId])) {
                $_SESSION['quantity'][$productId] = 0;
            }
        }
        $inIds = implode(',', array_map('intval', $productIds));
    }
} else {
    echo '<div class="empty-cart">
            <h1 style="margin-top: 50px; margin-bottom: 30px; color: #8d021f; font-size: 4em; text-align: center">Your Cart</h1>
            <h2 style="text-align: center;">Your cart is empty</h2>
          </div>';
    require_once './components/footer.php';
    exit();
}

if (empty($inIds)) {
    echo '<div class="empty-cart">
            <h1 style="margin-top: 50px; margin-bottom: 30px; color: #8d021f; font-size: 4em; text-align: center">Your Cart</h1>
            <h2 style="text-align: center;">Your cart is empty</h2>
          </div>';
    require_once './components/footer.php';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="./style/checkout.css">
    <script>
        function removeItem(productId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './components/remove-item.php?productId=' + productId, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    location.reload();
                }
            };
            xhr.send();
        }

        function redirectToPayment(totalAmount) {
            var productIds = JSON.parse('<?php echo json_encode($productIds); ?>');
            var quantities = JSON.parse('<?php echo json_encode($_SESSION['quantity']); ?>');
            var queryString = '';

            productIds.forEach(function(productId, index) {
                queryString += 'productIds[]=' + productId + '&quantity[]=' + quantities[productId];
                if (index < productIds.length - 1) {
                    queryString += '&';
                }
            });

            queryString += '&totalAmount=' + totalAmount;
            window.location.href = 'payment.php?' + queryString;
        }

        function updateQuantity(productId, newQuantity) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './components/update-quantity.php?productId=' + productId + '&quantity=' + newQuantity, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    location.reload();
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>
    <div class="checkout-content">
        <h1>Your Cart</h1>
        <?php
        $totalCartAmount = 0;
        $sql = "SELECT *, (p.stock_quantity - p.sold_quantity) AS available_stock FROM products p WHERE p.id_product IN ($inIds)";
        $res = $mysqli->query($sql);

        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $productId = $row['id_product'];
                $quantity = isset($_SESSION['quantity'][$productId]) ? $_SESSION['quantity'][$productId] : 1;
                $totalAmount = $row['price'] * $quantity;
                $totalCartAmount += $totalAmount;
                $availableStock = $row['available_stock'];

                echo '<div class="card">
                        <div class="image" style="background-image: url(' . $row['image_product'] . '); background-size: cover;"></div>
                        <div class="info-rows">
                            <div class="id-row">
                                <h2>ID: &nbsp;</h2>
                                <p class="id">' . $row['id_product'] . '</p>
                            </div>
                            <div class="name-row">
                                <h2>NAME: &nbsp;</h2>
                                <p class="name">' . $row['product_name'] . '</p>
                            </div>
                            <div class="price-row">
                                <h2>PRICE: &nbsp;</h2>
                                <p class="price">$' . $row['price'] . '</p>
                            </div>
                            <div class="quantity-row">
                                <h2>QUANTITY: &nbsp;</h2>
                                <input type="number" id="quantity_' . $row['id_product'] . '" value="' . $quantity . '" min="1" max="' . $availableStock . '" onchange="updateQuantity(' . $row['id_product'] . ', this.value)" oninput="validity.valid||(value=``)">
                            </div>
                            <div class="delete-row">
                                <button onclick="removeItem(' . $productId . ')">Remove</button>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo '<div class="empty-cart">
                    <h1 style="margin-top: 50px; margin-bottom: 30px; color: #8d021f; font-size: 4em; text-align: center">Your Cart</h1>
                    <h2 style="text-align: center;">Your cart is empty</h2>
                  </div>';
        }
        ?>
        <div class="total-row">
            <h2>TOTAL:</h2>
            <p>$<?php echo $totalCartAmount; ?></p>
        </div>
        <button class="confirm-btn" onclick="redirectToPayment(<?php echo $totalCartAmount; ?>)">Confirm</button>
    </div>
</body>
</html>
<?php
require_once './components/footer.php';
?>