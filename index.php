<?php
include 'includes/db.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Food Court | Home</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      color: white;
      background-image: url("images/backgroung.jpg");
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #343a40;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .nav-links a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      background: #007bff;
      padding: 8px 16px;
      border-radius: 5px;
      transition: background 0.3s;
    }

    .nav-links a:hover {
      background: #0056b3;
    }

    h1 {
      text-align: center;
      padding: 20px;
    }

    .stall-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      padding: 20px;
    }

    .stall-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      padding: 15px;
      text-align: center;
      width: 250px;
      transition: 0.3s;
    }

    .stall-card:hover {
      transform: scale(1.05);
    }

    .stall-card img {
      max-width: 100%;
      border-radius: 10px;
      width: 100px;
      height: 100px;
      object-fit: cover;
    }

    .stall-card a {
      display: inline-block;
      margin-top: 10px;
      padding: 8px 16px;
      background: #28a745;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }

    .stall-card a:hover {
      background: #218838;
    }
  </style>
</head>
<body>

<header>
  <h2>🍴 Food Court</h2>
  <div class="nav-links">
    <a href="user/login.php">User Login</a>
    <a href="user/cart.php">View Cart</a>
    <a href="admin/login.php">Admin Login</a>
    <a href="user/add_to_cart.php">Add to Cart</a>
    <a href="user/menu.php">menu</a>
    <a href="user/order.php">order</a>

  </div>
</header>

<h1>Welcome to the Food Court 🍽️</h1>
<form method="POST" action="add_to_cart.php">
  <input type="hidden" name="item_name" value="<?= $item['item_name'] ?>">
  <input type="hidden" name="price" value="<?= $item['price'] ?>">
</form>


<div class="stall-container">
  <?php
  $query = "SELECT * FROM stalls";
  $result = $conn->query($query);
  while ($row = $result->fetch_assoc()) {
    echo '
    <div class="stall-card">
      <img src="images/'.$row['image'].'" alt="'.$row['name'].'">
      <h3>'.$row['name'].'</h3>
      <a href="user/menu.php?stall_id='.$row['id'].'">View Menu</a>
    </div>
    ';
  }
  ?>
</div>

</body>
</html>
