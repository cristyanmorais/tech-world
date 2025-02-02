<?php
include('./database/connection.php');

require_once './components/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="./style/complete.css">
</head>
<body>
    <div class="complete-container">
        <?php
        // Saving purchase data in the 'purchases' table
        if (isset($_SESSION['id'])) { // Checking if the user is logged in
            $userId = $_SESSION['id'];
            $totalAmount = $_POST['total_amount']; // Getting the total amount that is sent via the form
            $paymentOption = $_POST['payment_option']; // Getting the payment option that is sent via the form

            // Inserting purchase data into the 'purchases' table
            $sql = "INSERT INTO purchases (user_id, total_amount, payment_option) VALUES ($userId, $totalAmount, '$paymentOption')";
            $result = $mysqli->query($sql);

            if ($result) { // If insertion is successful
                // Display success message
                echo '<h2>CHECKOUT COMPLETE!</h2>';
                echo '<p>Your payment is successful and the order is now complete.</p>';

                foreach ($_SESSION['quantity'] as $productId => $quantity) {
                    $updateSql = "UPDATE products SET sold_quantity = sold_quantity + $quantity WHERE id_product = $productId";
                    $updateResult = $mysqli->query($updateSql);
                    
                    // Checking if update was successful
                    if (!$updateResult) {
                        // Handling error, if any
                        echo '<h2>Error</h2>';
                        echo '<p>There was an error updating the sold_quantity quantity for some products.</p>';
                        exit(); // Exiting the script if error occurs
                    }
                }

                setcookie('cart', '', time() - 3600, '/'); // Clearing the cart cookie after successful purchase

            } else {
                // Handling failure to insert into 'purchases' table
                echo '<h2>Error</h2>';
                echo '<p>There was an error processing your order. Please try again later.</p>';
            }
        } else {
            // Redirecting to login page if user is not logged in
            header("Location: login.php");
            exit();
        }
        ?>
        <div class="btn">
            <button><a href="home.php">Close</a></button>
        </div>
    </div>
</body>
</html>

<?php
// Reset cart quantities after purchase
if (isset($_SESSION['quantity'])) {
    $_SESSION['quantity'] = array();
}
require_once './components/footer.php';
?>