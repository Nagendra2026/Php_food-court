<?php
include '../includes/db.php';
session_start();

// Redirect to login if not admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Error Reporting for Debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

$success = $error = "";

if (isset($_POST['add_stall'])) {
    $name = $_POST['stall_name'];
    $image = $_FILES['image']['name'];

    if ($image) {
        $target = ".images/domino.jpg" . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $stmt = $conn->prepare("INSERT INTO stalls (name, image) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $image);

            if ($stmt->execute()) {
                $success = "✅ Stall added successfully!";
            } else {
                $error = "❌ Failed to insert into database.";
            }
        } else {
            $error = "❌ Failed to upload image.";
        }
    } else {
        $error = "❌ No image selected.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Stalls</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
    }
    input, button {
      padding: 10px;
      margin: 10px 0;
    }
    .msg {
      font-weight: bold;
      color: green;
    }
    .err {
      font-weight: bold;
      color: red;
    }
  </style>
</head>
<body>

<h2>Add New Stall</h2>

<?php
if ($success) echo "<p class='msg'>$success</p>";
if ($error) echo "<p class='err'>$error</p>";
?>

<form method="POST" enctype="multipart/form-data">
  <input type="text" name="stall_name" placeholder="Stall Name" required><br>
  <input type="file" name="image" accept="image/*" required><br>
  <button type="submit" name="add_stall">Add Stall</button>
</form>

</body>
</html>
