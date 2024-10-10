<?php
session_start();
require_once 'conf/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $message = $_POST['message'];

    // Insert the message into the chats table
    $stmt = $conn->prepare("INSERT INTO chats (sender_id, receiver_id, message, status) VALUES (?, ?, ?, 'queued')");
    $receiver_id = 1; // Change this to the appropriate receiver ID
    $stmt->bind_param("iis", $user_id, $receiver_id, $message);
    $stmt->execute();
}
?>
