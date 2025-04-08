<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head><title>Welcome</title></head>
<body>
    <h1>Welcome, <?= $_SESSION['username'] ?>!</h1>
    <p><a href="menu.php">Browse Menu</a></p>
    <p><a href="cart.php">View Cart</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
