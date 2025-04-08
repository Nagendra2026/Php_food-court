<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item = [
        'item_name' => $_POST['item_name'],
        'price' => $_POST['price'],
        'quantity' => $_POST['quantity']
    ];

    $_SESSION['cart'][] = $item;

    header("Location: cart.php");
    exit();
}
?>
