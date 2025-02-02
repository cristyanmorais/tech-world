<?php
    if (!isset($_SESSION)) { // Start session if not already started
        session_start();
    }

    if(isset($_GET['logout'])) { // Logout functionality: If logout parameter is present in the URL, destroy the session and redirect to index.php
        session_destroy();
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techworld</title>
    <link rel="stylesheet" href="./style/header.css">
    <link rel="stylesheet" href="./style/footer.css">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="<?= 'assets/css/' . $pageStyle ?>">

    <script>
      function toggleMenu() {
            var navLinks = document.getElementById("navLinks");
            navLinks.classList.toggle("active");
        }
    </script>
</head>

<body>
    <header class="app-header">
    <div class="header-content">
            <img class="logo" src="./images/logo.png" alt="Logo MV" />
            <div class="menu-icon" onclick="toggleMenu()">
                <img class="menu-svg" src="./icons/menu.svg" alt="Menu Icon" />
            </div>
            <nav class="nav-links" id="navLinks">
                <a href="./" >HOME</a>
                <a href="./products.php">PRODUCTS</a>
                <?php   
                    if(!isset($_SESSION)) {
                        session_start();
                    }

                    if(isset($_SESSION['id'])) { // Check if user is logged in
                        // If logged in, display cart and logout links
                        echo '
                            <a href="checkout.php">CART</a>
                            <a href="?logout">LOGOUT</a>
                        ';
                    } else { // If not logged in, display login link
                        echo '<a href="./login.php">LOGIN</a>';
                    }
                ?>
            </nav>
        </div>
    </header>