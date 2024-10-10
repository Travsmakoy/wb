<?php
session_start();
require_once '../conf/config.php'; // Include your database connection file

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: index.php'); // Redirect to home if not admin
    exit();
}

// Get the user ID from the URL
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// Fetch messages for the specific user
$stmt = $conn->prepare("
    SELECT cm.message, cm.timestamp, u.first_name, u.last_name
    FROM chat_messages cm
    JOIN users u ON cm.user_id = u.id
    WHERE u.id = ?
    ORDER BY cm.timestamp ASC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'name' => htmlspecialchars($row['first_name'] . ' ' . $row['last_name']),
        'message' => htmlspecialchars($row['message']),
        'timestamp' => htmlspecialchars(date('Y-m-d H:i:s', strtotime($row['timestamp']))),
    ];
}

// Handle reply submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply'])) {
    $reply_message = trim($_POST['reply']);
    if (!empty($reply_message)) {
        $admin_id = $_SESSION['user_id']; // Assuming this is the admin's user ID
        $stmt = $conn->prepare("INSERT INTO chat_messages (user_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $reply_message);
        $stmt->execute();
        header("Location: view_chat.php?user_id=" . $user_id); // Redirect to the same page to show new message
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?php echo $messages ? $messages[0]['name'] : 'Customer'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        .chat-container {
            max-width: 800px;
            margin: 0 auto;
            border-radius: 8px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow-y: auto;
            max-height: 500px;
        }

        .message {
            padding: 10px;
            border-radius: 8px;
            margin: 5px 0;
            position: relative;
        }

        .message.admin {
            background-color: #007bff;
            color: white;
            text-align: right;
        }

        .message.customer {
            background-color: #e2e2e2;
            color: black;
        }

        .message-timestamp {
            font-size: 0.8rem;
            color: #6c757d;
            position: absolute;
            bottom: 5px;
            right: 10px;
        }

        .reply-form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .reply-form textarea {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            margin-bottom: 10px;
            resize: none;
            height: 60px;
        }

        .reply-form button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .reply-form button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            .chat-container {
                width: 100%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="chat-container">
    <h1>Chat with <?php echo $messages ? $messages[0]['name'] : 'Customer'; ?></h1>
    <?php if (empty($messages)): ?>
        <p>No messages yet.</p>
    <?php else: ?>
        <?php foreach ($messages as $msg): ?>
            <div class="message <?php echo $msg['name'] === 'You' ? 'admin' : 'customer'; ?>">
                <p><?php echo $msg['message']; ?></p>
                <div class="message-timestamp"><?php echo $msg['timestamp']; ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="reply-form">
    <form method="POST">
        <textarea name="reply" placeholder="Type your reply here..." required></textarea>
        <button type="submit">Send Reply</button>
    </form>
</div>

</body>
</html>
