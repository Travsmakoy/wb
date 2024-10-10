<?php
// chat.php
session_start();
require_once '../conf/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$is_admin = $_SESSION['is_admin'];

if ($is_admin) {
    $sql = "SELECT DISTINCT u.id, u.username FROM users u 
            JOIN messages m ON (u.id = m.sender_id OR u.id = m.receiver_id) 
            WHERE (m.sender_id = $user_id OR m.receiver_id = $user_id) AND u.is_admin = 0";
} else {
    $sql = "SELECT id, username FROM users WHERE is_admin = 1";
}

$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="chat-container">
        <div class="user-list">
            <h3>Chats</h3>
            <ul>
                <?php foreach ($users as $user): ?>
                    <li data-user-id="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="chat-window">
            <div id="messages"></div>
            <form id="message-form">
                <input type="text" id="message-input" placeholder="Type a message..." required>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="chat.js"></script>
</body>
</html>
