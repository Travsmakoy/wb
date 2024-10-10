<?php
session_start();
require_once '../conf/config.php'; // Database connection

// Fetch chats for the current user
$user_id = $_SESSION['user_id']; // Assuming you have a user_id stored in the session
$stmt = $conn->prepare("SELECT c.id, c.message, c.timestamp, c.receiver_id, c.sender_id, 
                         CONCAT(u.first_name, ' ', u.last_name) AS name 
                         FROM chats c 
                         JOIN users u ON c.sender_id = u.id 
                         WHERE c.receiver_id = ? 
                         GROUP BY c.sender_id 
                         ORDER BY c.timestamp DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$chats = $result->fetch_all(MYSQLI_ASSOC);

// Fetch queued chats
$stmt = $conn->prepare("SELECT c.*, CONCAT(u.first_name, ' ', u.last_name) AS name 
                         FROM chats c 
                         JOIN users u ON c.sender_id = u.id 
                         WHERE c.status = 'queued' 
                         ORDER BY c.timestamp ASC LIMIT 2");
$stmt->execute();
$result = $stmt->get_result();
$queued_chats = $result->fetch_all(MYSQLI_ASSOC);

// Fetch supervised chats
$stmt = $conn->prepare("SELECT c.*, CONCAT(u.first_name, ' ', u.last_name) AS name 
                         FROM chats c 
                         JOIN users u ON c.sender_id = u.id 
                         WHERE c.status = 'supervised' 
                         ORDER BY c.timestamp DESC LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();
$supervised_chats = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
        }
        .container {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 300px;
            background-color: #fff;
            border-right: 1px solid #e0e0e0;
            overflow-y: auto;
        }
        .chat-list {
            padding: 10px;
        }
        .chat-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 5px;
            cursor: pointer;
        }
        .chat-item:hover {
            background-color: #e4e6eb;
        }
        .chat-item .name {
            font-weight: 500;
            margin-bottom: 3px;
        }
        .chat-item .last-message {
            font-size: 0.9em;
            color: #65676b;
        }
        .chat-section {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }
        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            background-color: #0078d4;
            color: white;
        }
        .chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f0f2f5;
        }
        .message {
            max-width: 70%;
            margin-bottom: 15px;
            display: flex;
        }
        .message-content {
            padding: 10px 15px;
            border-radius: 18px;
            background-color: #e4e6eb;
            display: inline-block;
            word-wrap: break-word;
        }
        .message.sent .message-content {
            background-color: #0078d4;
            color: white;
            margin-left: auto; /* Align to right */
        }
        .chat-input {
            padding: 15px;
            border-top: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
        }
        .chat-input input {
            flex-grow: 1;
            border: none;
            padding: 10px;
            border-radius: 20px;
            background-color: #f0f2f5;
        }
        .chat-input button {
            background-color: #0078d4;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 20px;
            margin-left: 10px;
            cursor: pointer;
        }
        .no-messages {
            padding: 10px;
            color: #65676b;
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="chat-list">
            <div class="section-title">My chats</div>
            <?php if (empty($chats)): ?>
                <div class="no-messages">No messages found.</div>
            <?php else: ?>
                <?php foreach ($chats as $chat): ?>
                    <div class="chat-item">
                        <div>
                            <div class="name"><?php echo htmlspecialchars($chat['name'] ?? 'Unknown'); ?></div>
                            <div class="last-message"><?php echo htmlspecialchars(substr($chat['message'] ?? '', 0, 30)); ?>...</div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="section-title">Queued chats</div>
            <?php if (empty($queued_chats)): ?>
                <div class="no-messages">No queued chats found.</div>
            <?php else: ?>
                <?php foreach ($queued_chats as $chat): ?>
                    <div class="chat-item">
                        <div>
                            <div class="name"><?php echo htmlspecialchars($chat['name'] ?? 'Unknown'); ?></div>
                            <div class="last-message">Waiting for chat</div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="section-title">Supervised chats</div>
            <?php if (empty($supervised_chats)): ?>
                <div class="no-messages">No supervised chats found.</div>
            <?php else: ?>
                <?php foreach ($supervised_chats as $chat): ?>
                    <div class="chat-item">
                        <div>
                            <div class="name"><?php echo htmlspecialchars($chat['name'] ?? 'Unknown'); ?></div>
                            <div class="last-message"><?php echo htmlspecialchars(substr($chat['message'] ?? '', 0, 30)); ?>...</div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="chat-section">
        <div class="chat-header">
            <h2>Current Chat Name</h2>
        </div>
        <div class="chat-messages">
            <!-- Chat messages will be dynamically loaded here -->
        </div>
        <div class="chat-input">
            <input type="text" placeholder="Type a message...">
            <button>Send</button>
        </div>
    </div>
</div>
</body>
</html>
