<?php
include '../includes/db.php';

if (isset($_POST['place_order'])) {
    $customer = $_POST['customer_name'];
    $item = $_POST['item_name'];
    $qty = $_POST['quantity'];

    $stmt = $conn->prepare("SELECT price FROM menu_items WHERE item_name = ?");
    $stmt->bind_param("s", $item);
    $stmt->execute();
    $price = $stmt->get_result()->fetch_assoc()['price'];

    $total = $qty * $price;

    $insert = $conn->prepare("INSERT INTO orders (customer_name, item_name, quantity, total_price) VALUES (?, ?, ?, ?)");
    $insert->bind_param("ssii", $customer, $item, $qty, $total);
    $insert->execute();

    echo "<h3>Order placed! Total: $".$total."</h3>";
    echo "<a href='../index.php'>Back to Home</a>";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Order</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/script.js"></script> 
</head>
<body>

<h2>Place Your Order</h2>

<form method="POST" onsubmit="return confirmOrder();">
  <input type="text" name="name" placeholder="Your Name" required>
  <input type="text" name="food" placeholder="Food Item" required>
  <input type="text" name="quantity" placeholder="count" required>
  <button type="submit">Place Order</button>
</form>

</body>
</html>