<?php
require_once './components/header.php';
?>

<?php
include('./database/connection.php');

if (isset($_POST['username']) && isset($_POST['password'])) { // Checking if username and password are set in the POST request

    $username = $mysqli->real_escape_string($_POST['username']); // Escaping username to prevent SQL injection
    $password = $mysqli->real_escape_string($_POST['password']); // Escaping password to prevent SQL injection

    if (empty($username)) { // Displaying error message if username is empty
        echo "Inform the Username";
    } else if (empty($password)) { // Displaying error message if password is empty
        echo "Inform the Password";
    } else {
        $sql_code = "SELECT * FROM users WHERE BINARY username = '$username' AND BINARY password = '$password'";
        $sql_query = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);

        $quantity = $sql_query->num_rows; // Getting the number of rows returned by the query

        if ($quantity == 1) { // If one row is returned, indicating successful login
            $user = $sql_query->fetch_assoc(); // Fetching the user data from the query result

            if (!isset($_SESSION)) {
                session_start(); // Starting the session if not already started
            }

            $_SESSION['id'] = $user['id_user']; // Storing user ID in session
            $_SESSION['name'] = $user['first_name']; // Storing user's first name in session

            header("Location: index.php"); // Redirecting to index.php after successful login
        } 
        else { // Displaying error message for incorrect credentials
            echo "Incorrect Credentials";
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
     <link rel="stylesheet" href="./style/login.css">
</head>
<body>
    <section id="container-login">
        <div class="login-content">
            <div class="login-img">
                <img src="./images/login-render.png" alt="render image">
            </div>
            <div class="login-fields">
                <h2>Customer Login</h2>
                <form class="form-login" method="POST">
                    <div class="form-username">
                        <label for="username">Username</label>
                        <input 
                            type="username" 
                            name="username" 
                            id="username"
                            placeholder=""
                            required
                        >
                    </div>
                    <div class="form-password">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            placeholder="" 
                            required   
                        >
                    </div>
                    <button 
                        type="submit"
                        class="login-btn"
                    >
                        Login
                    </button>
                </form>
                <a href="./register.php">Create an Account</a>
            </div>
        </div>
    </section>
</body>
</html>

<?php
require_once './components/footer.php';
?>