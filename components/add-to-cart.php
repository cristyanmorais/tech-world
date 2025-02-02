<?php
if (isset($_GET['productId'])) { // Check if product ID is provided via GET request
    $productId = $_GET['productId']; // Retrieve the product ID from the GET request

    if (!isset($_COOKIE['cart'])) { // Initialize or retrieve the cart from the cookie
        $cart = array(); // Initialize an empty cart array if 'cart' cookie doesn't exist
    } else { // Retrieve and decode the cart array from the cookie
        $cart = json_decode($_COOKIE['cart'], true); 
    }

    $cart[] = $productId; // Add the retrieved product ID to the cart array

    // Update the 'cart' cookie with the updated cart array
    setcookie('cart', json_encode($cart), time() + (86400), "/"); // Set the cookie to expire in 24 hours

    echo "Product added to cart successfully."; // Echo success message
} else {
    echo "Product ID not provided."; // Echo error message if product ID is not provided in the GET request
}
?>