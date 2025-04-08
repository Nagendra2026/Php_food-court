<?php
include '../includes/db.php';

// ✅ Safely get the stall_id from the URL
$stall_id = isset($_GET['stall_id']) ? (int)$_GET['stall_id'] : 0;

if ($stall_id <= 0) {
    echo "<p>Invalid stall selected.</p>";
    exit();
}

// ✅ Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT name FROM stalls WHERE id = ?");
$stmt->bind_param("i", $stall_id);
$stmt->execute();
$result = $stmt->get_result();
$stall = $result->fetch_assoc();

if (!$stall) {
    echo "<p>Stall not found.</p>";
    exit();
}

// ✅ Get menu items
$menu_stmt = $conn->prepare("SELECT * FROM menu_items WHERE stall_id = ?");
$menu_stmt->bind_param("i", $stall_id);
$menu_stmt->execute();
$menu = $menu_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title><?= htmlspecialchars($stall['name']) ?> Menu</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    .menu-item {
      border: 1px solid #ccc;
      margin: 15px 0;
      padding: 15px;
      border-radius: 8px;
    }
  </style>
</head>
<body>

<h2><?= htmlspecialchars($stall['name']) ?> Menu</h2>

<?php while ($item = $menu->fetch_assoc()): ?>
  <div class="menu-item">
    <h3><?= htmlspecialchars($item['item_name']) ?> - ₹<?= number_format($item['price'], 2) ?></h3>
    <form method="POST" action="add_to_cart.php">
      <input type="hidden" name="item_name" value="<?= htmlspecialchars($item['item_name']) ?>">
      <input type="hidden" name="price" value="<?= htmlspecialchars($item['price']) ?>">
      <label>Quantity:</label>
      <input type="number" name="quantity" value="1" min="1" required>
      <button type="submit">Add to Cart</button>
    </form>
  </div>
<?php endwhile; ?>

</body>
</html>
