<?php
$servername = "26b.h.filess.io";
$username = "inno_samehimdig";
$password = "travsmakoy55";
$dbname = "inno_samehimdig";
$port = 3307; // Add the port here

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
