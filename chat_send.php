<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$data = json_decode(file_get_contents('php://input'), true);
$message = $data['message'];
$userId = $_SESSION['user_id']; // User ID from session

if ($message && $userId) {
    $stmt = $conn->prepare("INSERT INTO chat_messages (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $userId, $message);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
