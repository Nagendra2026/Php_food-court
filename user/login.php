<?php
session_start();
include '../includes/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Find user
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: user_home.php"); // redirect to user home
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <style>
        body { font-family: Arial; background-color: #f0f0f0; }
        .login-box {
            width: 300px; padding: 20px; background: white;
            margin: 100px auto; box-shadow: 0 0 10px gray; border-radius: 8px;
        }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { background-color: green; color: white; border: none; padding: 10px; width: 100%; }
        .error { color: red; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>User Login</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
