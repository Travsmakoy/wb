<?php
// send_message.php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['receiver_id']) || !isset($_POST['content'])) {
    exit('Unauthorized');
}

$sender_id = $_SESSION['user_id'];
$receiver_id = $conn->real_escape_string($_POST['receiver_id']);
$content = $conn->real_escape_string($_POST['content']);

$sql = "INSERT INTO messages (sender_id, receiver_id, content) VALUES ($sender_id, $receiver_id, '$content')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>