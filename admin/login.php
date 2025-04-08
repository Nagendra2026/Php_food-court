<?php
include '../includes/db.php';

$username = 'admin';
$plain_password = 'admin';
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

// Check if user already exists
$check = $conn->prepare("SELECT * FROM admin WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$result = $check->get_result();
echo password_hash('admin', PASSWORD_DEFAULT);



if ($result->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        echo "✅ Admin user created successfully!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
} else {
    echo "⚠️ Admin already exists.";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button name="login">Login</button>
        </form>
    </div>
</body>
</html>
