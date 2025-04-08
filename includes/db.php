<?php
$host = "localhost";
$user = "root";
$password = ""; // Use your MySQL password here
$dbname = "foodcourt_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
