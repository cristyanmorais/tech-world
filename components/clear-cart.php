<?php
setcookie('cart', '', time() - 3600, '/');

echo "Cart cleared successfully";
?>