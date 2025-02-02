<?php
if (isset($_GET['productId'])) { // Check if product ID is provided via GET request
    $productId = $_GET['productId']; // Retrieve the product ID from the GET request

    if (isset($_COOKIE['cart'])) { // Check if 'cart' cookie exists
        $productIds = json_decode($_COOKIE['cart'], true); // Decode the JSON-encoded cart array from the cookie

        $index = array_search($productId, $productIds); // Search for the product ID in the cart array

        if ($index !== false) {
            unset($productIds[$index]); // Remove the product ID from the cart array

            // Update the 'cart' cookie with the updated cart array
            setcookie('cart', json_encode($productIds), time() + (86400), "/"); // Set the cookie to expire in 24 hours

            echo "Product removed from cart successfully."; // Echo success message
        } else {
            echo "The product was not found in the cart."; // Echo message if the product is not found in the cart
        }
    } else {
        echo "The cart is empty."; // Echo message if the cart is empty
    }
} else {
    echo "Product ID not provided."; // Echo error message if product ID is not provided in the GET request
}
?>