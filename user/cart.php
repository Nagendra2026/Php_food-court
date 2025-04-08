<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (isset($_POST['place_order'])) {
    $customer = $_POST['customer_name'];
    $order_ids = [];
    $grand_total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $item_name = $item['item_name'];
        $quantity = (int)$item['quantity'];
        $price = (float)$item['price'];
        $total = $quantity * $price;
        $grand_total += $total;

        $stmt = $conn->prepare("INSERT INTO orders (customer_name, item_name, quantity, total_price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $customer, $item_name, $quantity, $total);
        $stmt->execute();

        // Collect inserted order ID for payment reference (optional)
        $order_ids[] = $conn->insert_id;
    }

    $_SESSION['cart'] = [];

    // Save order info for payment
    $_SESSION['last_order_total'] = $grand_total;
    $_SESSION['order_ids'] = $order_ids;

    // Redirect to payment
    header("Location: payment.php");
    exit();
}

if (isset($_GET['remove'])) {
    $remove_index = $_GET['remove'];
    unset($_SESSION['cart'][$remove_index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
    header("Location: cart.php"); // Refresh to avoid resubmission
    exit();
}


// Place order logic
if (!empty($_SESSION['cart'])): ?>
    <table>
        <tr><th>Item</th><th>Price</th><th>Quantity</th><th>Total</th></tr>
        <?php
        $grand_total = 0;
        foreach ($_SESSION['cart'] as $item):
            if (!isset($item['price'], $item['quantity'])) continue;

            $price = (float)$item['price'];
            $quantity = (int)$item['quantity'];
            $total = $price * $quantity;
            $grand_total += $total;
        ?>
            <tr>
                <td><?= htmlspecialchars($item['item_name']) ?></td>
                <td>₹<?= number_format($price, 2) ?></td>
                <td><?= $quantity ?></td>
                <td>₹<?= number_format($total, 2) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Grand Total</strong></td>
            <td><strong>₹<?= number_format($grand_total, 2) ?></strong></td>
        </tr>
    </table>
<?php else: ?>
    <p style="text-align:center;">🛒 Your cart is empty.</p>
<?php endif; ?>



<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        table {
            background: white;
            border-collapse: collapse;
            width: 80%;
            margin: auto;
        }

        th, td {
            padding: 12px 20px;
            text-align: center;
            border: 1px solid #ccc;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 200px;
        }

        button {
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: darkgreen;
        }

        .msg {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<h2>Your Cart</h2>

<?php if (!empty($_SESSION['cart'])): ?>
    <table>
        <tr><th>Item</th><th>Price</th><th>Quantity</th><th>Total</th></tr>
        <?php
        $grand_total = 0;
        foreach ($_SESSION['cart'] as $item):
            $total = (float)$item['price'] * (int)$item['quantity'];
            $grand_total += $total;
        ?>
            <tr>
                <td><?= htmlspecialchars($item['item_name']) ?></td>
                <td>₹<?= number_format($item['price'], 2) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>₹<?= number_format($total, 2) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Grand Total</strong></td>
            <td><strong>₹<?= number_format($grand_total, 2) ?></strong></td>
        </tr>


        
        <a href="cart.php?remove=<?= $index ?>" style="color: red;">Remove</a>

    </table>

    <form method="POST">
        <input type="text" name="customer_name" placeholder="Your Name" required>
        <button type="submit" name="place_order">Place Order</button>
    </form>

<?php else: ?>
    <p style="text-align:center;">🛒 Your cart is empty.</p>
<?php endif; ?>

<?php if (isset($msg)) echo "<p class='msg'>$msg</p>"; ?>


</body>
</html>
