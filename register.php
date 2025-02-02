<?php
require_once './components/header.php';

include('./database/connection.php');

if (isset($_POST['username']) && isset($_POST['password'])) { // Checking if form fields are submitted
    if (empty($_POST['username'])) { // Displaying error if username field is empty
        echo "Please fill in the username field";
    } elseif (empty($_POST['password'])) { // Displaying error if password field is empty
        echo "Please fill in the password field";
    } elseif ($_POST['password'] !== $_POST['c-password']) { // Displaying error if password and confirmation password do not match
        echo "Password and confirmation password do not match";
    } else {
        $username = $mysqli->real_escape_string($_POST['username']);

        $checkUsernameQuery = "SELECT username FROM users WHERE username = '$username'";
        $result = $mysqli->query($checkUsernameQuery);

        if ($result->num_rows > 0) {
            echo "Username already linked to an account"; // Displaying error if username already exists
        } else {
            $name = $mysqli->real_escape_string($_POST['name']);
            $last_name = $mysqli->real_escape_string($_POST['l-name']);
            $username = $mysqli->real_escape_string($_POST['username']);
            $password = $mysqli->real_escape_string($_POST['password']);
            $address = $mysqli->real_escape_string($_POST['address']);
            $phone = $mysqli->real_escape_string($_POST['phone']);

            $sql_code = "insert into users(first_name, last_name, username, password, address, phone_number) values ('$name', '$last_name', '$username', '$password', '$address', '$phone')";
            $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);

            if ($res === true) {
                echo "<script>alert('Registration successful!');</script>";
                header("Location: login.php"); // Redirecting to login page after successful registration
            } else {
                echo "<script>alert('Registration failed!');</script>";
                header("Location: login.php"); // Redirecting to login page if registration fails
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <link rel="stylesheet" href="./style/global.css">
     <link rel="stylesheet" href="./style/register.css">
</head>
<body>
    <section id="container-register">
        <div class="register-content">
                <h2>Sign-in</h2>
            <form class="form-register" action="" method="POST">
                <div class="register-fields">
                <div class="l-half">
                <div class="form-name">
                    <label for="name">First Name</label>
                    <input 
                        type="name" 
                        name="name" 
                        id="name"
                        placeholder="Type your name..."
                        required
                    >
                </div>
                <div class="form-l-name">
                    <label for="l-name">Last Name</label>
                    <input 
                        type="l-name" 
                        name="l-name" 
                        id="l-name"
                        placeholder="Type your last name..."
                        required
                    >
                </div>
                <div class="form-username">
                    <label for="username">Username</label>
                    <input 
                        type="username" 
                        name="username" 
                        id="username"
                        placeholder="Type your Username..."
                        required
                    >
                </div>
                <div class="form-address">
                    <label for="address">Address</label>
                    <input 
                        type="address" 
                        name="address" 
                        id="address"
                        placeholder="Type your address..." 
                        required   
                    >
                </div>
                </div>

                <div class="r-half">
                <div class="form-phone">
                    <label for="phone">Phone Number</label>
                    <input 
                        type="phone" 
                        name="phone" 
                        id="phone"
                        placeholder="Type your phone..." 
                        required   
                    >
                </div>
                <div class="form-password">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        placeholder="Type your password..." 
                        required   
                    >
                </div>
                <div class="form-c-password">
                    <label for="c-password">Confirm Password</label>
                    <input 
                        type="password" 
                        name="c-password" 
                        id="c-password"
                        placeholder="Type your password again..." 
                        required   
                    >
                </div>
                </div>
                </div>

                <div class="buttons">
                    <button 
                        class="cancel-btn"
                    >
                        Cancel
                    </button>

                    <button 
                        type="submit"
                        class="register-btn"
                    >
                        Sign-in
                    </button>
                    
                </div>
            </form>
        </div>
    </section>
</body>
</html>

<?php
require_once './components/footer.php';
?>