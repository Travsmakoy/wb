<?php
// Database connection settings
$host = 'localhost'; // or your database host
$db = 'vapeshop1'; // the name of your database
$user = 'root'; // your MySQL username
$pass = ''; // your MySQL password

// Create a new mysqli instance and connect to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
