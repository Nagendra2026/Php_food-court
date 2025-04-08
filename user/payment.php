<?php
session_start();

if (!isset($_SESSION['last_order_total'])) {
    header("Location: cart.php");
    exit();
}

$amount = $_SESSION['last_order_total'];
$order_ids = $_SESSION['order_ids'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            padding: 40px;
            text-align: center;
        }

        .payment-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        .amount {
            font-size: 24px;
            color: green;
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 25px;
            background: green;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background: darkgreen;
        }
    </style>
</head>
<body>

<div class="payment-box">
    <h2>Confirm Your Payment</h2>
    <div class="amount">Total Amount: ₹<?= number_format($amount, 2) ?></div>

    <form method="POST" action="success.php">
        <input type="hidden" name="paid_amount" value="<?= $amount ?>">
        <button type="submit" class="btn">Pay Now</button>
    </form>
</div>

</body>
</html>
