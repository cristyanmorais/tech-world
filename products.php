<?php
include('./database/connection.php');

require_once './components/header.php';

$search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : ''; // Getting search query from URL and sanitizing it.

$sql = "SELECT * FROM products WHERE product_name LIKE '%$search%'"; // SQL query to select products based on search query.

$res = $mysqli->query($sql); // Executing the SQL query.
$qtd = $res->num_rows; // Getting the number of rows returned by the query.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="./style/global.css">
     <link rel="stylesheet" href="./style/products.css">

     <script>
        function addToCart(productId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './components/add-to-cart.php?productId=' + productId, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    console.log(xhr.responseText);
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>
<section id="products">
    <div class="container">
        <div class="filter">
            <form class="form-filter" action="" method="GET">
                <div class="search">
                    <button type="submit">
                        <img src="./icons/search.svg" alt="search">
                    </button>
                    <input type="search" name="search" id="search" value="<?php echo $search; ?>">
                </div>
            </form>

        </div>
        <div class="products-content">
            <div class="card-list-content">
                <ul class="card-list">
                    <?php
                        if ($qtd > 0) { // Checking if there are products available
                            while ($row = $res->fetch_object()) { // Iterating through the result set
                                $available = $row->stock_quantity - $row->sold_quantity; // Calculating available tickets
                                echo ' <li id="product_<?php echo $row->id_product; ?>" class="card"> <!-- Starting a list item -->
                                        <div class="overlay" onclick="addToCart(' . $row->id_product .')"></div> <!-- Adding overlay for click event -->
                                        <div class="card-image">
                                            <img src="' . $row->image_product . '" alt="product cover">
                                        </div>
                                        <div class="card-title">
                                            <h4 class="title">' . $row->product_name . '</h4>
                                            <h4 class="artist">' . $row->brand . '</h4>                                                                                           
                                        </div>
                                        <div class="card-description">
                                ';
                                $description_lines = explode("\n", $row->description_product); // Splitting description into lines
                                foreach ($description_lines as $line) { // Iterating through each description line
                                    echo '<p>' . $line . '</p>'; // Displaying each description line
                                }
                                echo '</div> <!-- Closing card-description div -->
                                    <div class="price">
                                        <p>' . $available . ' left</p>
                                        <h4>$' . $row->price . '</h4>
                                    </div>
                                    <div class="overlay-text">ADD TO CART</div>
                                </li>';
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    </section>
</body>
</html>

<?php
require_once './components/footer.php';
?>