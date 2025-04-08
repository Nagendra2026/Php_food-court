<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Orders</title>
  <style>
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; }
    th { background: #444; color: white; }
  </style>
</head>
<body>

<h2>All Orders</h2>
<table>
  <tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Item</th>
    <th>Qty</th>
    <th>Total</th>
    <th>Time</th>
  </tr>
  <?php
  $orders = $conn->query("SELECT * FROM orders ORDER BY order_time DESC");
  while ($order = $orders->fetch_assoc()) {
      echo "<tr>
        <td>{$order['id']}</td>
        <td>{$order['customer_name']}</td>
        <td>{$order['item_name']}</td>
        <td>{$order['quantity']}</td>
        <td>{$order['total_price']}</td>
        <td>{$order['order_time']}</td>
      </tr>";
  }
  ?>
</table>

</body>
</html>
