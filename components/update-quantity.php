<?php
session_start(); // Start the session

if (isset($_GET['productId']) && isset($_GET['quantity'])) { // Check if productId and quantity parameters are set in the GET request
    $productId = intval($_GET['productId']); // Convert productId to an integer
    $quantity = intval($_GET['quantity']); // Convert quantity to an integer

    // Save the new quantity in the session
    $_SESSION['quantity'][$productId] = $quantity;

    echo 'Quantity updated successfully.'; // Echo success message
} else {
    echo 'Invalid parameters.'; // Echo error message if parameters are missing
}
?>