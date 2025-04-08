<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $order_ids = $_SESSION['order_ids'];

    foreach ($order_ids as $order_id) {
        $stmt = $conn->prepare("INSERT INTO payments (order_id, amount, status) VALUES (?, ?, 'Success')");
        $stmt->bind_param("id", $order_id, $amount);
        $stmt->execute();
    }

    // Clear session
    unset($_SESSION['last_order_total']);
    unset($_SESSION['order_ids']);

    echo "<h2>✅ Payment Successful!</h2>";
    echo "<p>Thank you for your order.</p>";
    echo "<a href='menu_list.php'>Back to Menu</a>"; // optional
} else {
    echo "Invalid payment request.";
}
