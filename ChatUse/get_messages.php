<?php
session_start();
require_once '../conf/config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['other_user_id'])) {
    exit('Unauthorized');
}

$user_id = $_SESSION['user_id'];
$other_user_id = $conn->real_escape_string($_GET['other_user_id']);

$sql = "SELECT m.*, CONCAT(u.first_name, ' ', u.last_name) AS sender_name
        FROM messages m
        JOIN users u ON m.sender_id = u.id
        WHERE (sender_id = $user_id AND receiver_id = $other_user_id)
           OR (sender_id = $other_user_id AND receiver_id = $user_id)
        ORDER BY timestamp ASC";


$result = $conn->query($sql);
$messages = $result->fetch_all(MYSQLI_ASSOC);

// Mark messages as read
$update_sql = "UPDATE messages SET is_read = 1 
               WHERE sender_id = $other_user_id AND receiver_id = $user_id";
$conn->query($update_sql);

echo json_encode($messages);