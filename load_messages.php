<?php
session_start();
require_once 'conf/config.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT c.*, CONCAT(u.first_name, ' ', u.last_name) AS name 
                         FROM chats c 
                         JOIN users u ON c.sender_id = u.id 
                         WHERE c.receiver_id = ? 
                         ORDER BY c.timestamp DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$chats = $result->fetch_all(MYSQLI_ASSOC);

foreach ($chats as $chat) {
    $class = $chat['sender_id'] == $user_id ? 'sent' : 'received';
    echo '<div class="message ' . $class . '">
            <div class="message-content">' . htmlspecialchars($chat['message']) . '</div>
          </div>';
}
?>
