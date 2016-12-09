<?php

session_unset($_SESSION['cart']);
session_destroy($_SESSION['cart']);
session_write_close($_SESSION['cart']);
setcookie(session_name($_SESSION['cart']), '', 0, '/');
session_regenerate_id(true);
header("Location:home.php")
?>

