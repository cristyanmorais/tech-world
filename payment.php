<?php
include('./database/connection.php');

require_once './components/header.php';

if (isset($_SESSION['id']) && isset($_SESSION['name'])) { // Checking if the user is logged in
    $userId = $_SESSION['id'];
    $userName = $_SESSION['name'];

    // Query the database to get user details
    $sql = "SELECT * FROM users WHERE id_user = $userId";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) { // If user details are found
        $user = $result->fetch_assoc();
        $firstName = $user['first_name'];
        $lastName = $user['last_name'];
        $address = $user['address'];
        $phone = $user['phone_number'];
    }

    $totalAmount = $_GET['totalAmount'];
} else {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="./style/payment.css">

    <script>
        function cancelPayment() { // Function to cancel payment and redirect to cart page
            window.location.href = 'cart.php';
        }
    </script>
</head>
<body>
    <div class="payment-container">
        <h1>Checkout Payment</h1>
        <form action="./complete.php" method="post"> <!-- Form for payment details -->
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $firstName; ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $lastName; ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?php echo $address; ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="payment_option">Payment Option</label>
                <select id="payment_option" name="payment_option" required>
                    <option value="paypal">PayPal</option>
                    <option value="visa">VISA</option>
                    <option value="mastercard">MasterCard</option>
                    <option value="direct_deposit">Direct Deposit</option>
                </select>
            </div>
            <div class="form-group">
                <label for="total-amount">Total</label>
                <input type="text" name="total_amount" value="<?php echo $totalAmount; ?>" readonly>
            </div>

            <div class="confirm-btn">
                <button type="submit" name="confirm_payment">Pay Now</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
require_once './components/footer.php';
?>