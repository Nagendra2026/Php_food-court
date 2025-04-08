<?php
include '../includes/db.php';
session_start();

// Simple login check
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: #f9f9f9;
    }
    h1 {
      color: #333;
    }
    .section {
      margin-bottom: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }
    th {
      background: #007bff;
      color: white;
    }
  </style>
</head>
<body>

<h1>Admin Dashboard</h1>

<div class="section">
  <h2>Food Stalls</h2>
  <table>
    <tr><th>ID</th><th>Name</th></tr>
    <?php
    $stalls = $conn->query("SELECT * FROM stalls");
    while ($s = $stalls->fetch_assoc()) {
        echo "<tr><td>{$s['id']}</td><td>{$s['name']}</td></tr>";
    }
    ?>
  </table>
</div>

<div class="section">
  <h2>Menu Items</h2>
  <table>
    <tr><th>Stall ID</th><th>Item Name</th><th>Price</th></tr>
    <?php
    $menu = $conn->query("SELECT * FROM menu_items");
    while ($m = $menu->fetch_assoc()) {
        echo "<tr><td>{$m['stall_id']}</td><td>{$m['item_name']}</td><td>{$m['price']}</td></tr>";
    }
    ?>
  </table>
</div>

<div class="section">
  <h2>Recent Orders</h2>
  <table>
    <tr><th>Customer</th><th>Item</th><th>Qty</th><th>Total</th><th>Time</th></tr>
    <?php
    $orders = $conn->query("SELECT * FROM orders ORDER BY order_time DESC LIMIT 10");
    while ($o = $orders->fetch_assoc()) {
        echo "<tr><td>{$o['customer_name']}</td><td>{$o['item_name']}</td><td>{$o['quantity']}</td><td>{$o['total_price']}</td><td>{$o['order_time']}</td></tr>";
    }
    ?>
  </table>
</div>

</body>
</html>
