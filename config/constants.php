<?php  
session_start();
// Create Constants to Store Non-Repeating Values
define('SITEURL', 'http://localhost/food-order-main/'); // Update if needed
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '9700');
define('DB_NAME', 'food-order');
// Database Connection
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die("Database Connection Failed: " . mysqli_connect_error());
// Selecting Database
$db_select = mysqli_select_db($conn, DB_NAME) or die("Database Selection Failed: " . mysqli_error($conn));
?>
