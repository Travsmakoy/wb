<?php
// customer_chat.php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

$admin_id = $conn->query("SELECT id FROM users WHERE is_admin = 1")->fetch_assoc()['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Chat</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100%;
            overflow: hidden;
        }
        .container {
            display: flex;
            height: 100%;
        }
        .sidebar {
            width: 300px;
            background-color: #f3f2f1;
            border-right: 1px solid #e1dfdd;
            display: flex;
            flex-direction: column;
        }
        .header {
            padding: 20px;
            background-color: #464775;
            color: white;
        }
        .chat-list {
            flex-grow: 1;
            overflow-y: auto;
        }
        .chat-item {
            padding: 15px 20px;
            border-bottom: 1px solid #e1dfdd;
            cursor: pointer;
        }
        .chat-item:hover, .chat-item.active {
            background-color: #e1dfdd;
        }
        .chat-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .chat-header {
            padding: 20px;
            background-color: #f3f2f1;
            border-bottom: 1px solid #e1dfdd;
        }
        .chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            max-width: 22%;
        }
        .message.received {
            background-color: #f3f2f1;
            align-self: flex-start;
        }
        .message.sent {
            background-color: #e1dfdd;
            align-self: flex-end;
            margin-left: auto;
            text-align: right;
        }
        .chat-input {
            padding: 20px;
            background-color: #f3f2f1;
            border-top: 1px solid #e1dfdd;
        }
        .chat-input form {
            display: flex;
        }
        .chat-input input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #e1dfdd;
            border-radius: 5px;
        }
        .chat-input button {
            margin-left: 10px;
            padding: 10px 20px; 
            background-color: #464775;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="chat-area">
            <div class="chat-header">
                <h3>Chat with Admin</h3>
            </div>
            <div class="chat-messages" id="chatMessages">
                <!-- Chat messages will be populated here -->
            </div>
            <div class="chat-input">
                <form id="chatForm">
                    <input type="text" id="messageInput" placeholder="Type a message..." required>
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showMessages() {
            $.get('get_messages.php', { other_user_id: <?php echo $admin_id; ?> }, function(messages) {
                const chatMessages = $('#chatMessages');
                chatMessages.empty();
                messages.forEach(message => {
                    const messageClass = message.sender_id == <?php echo $_SESSION['user_id']; ?> ? "sent" : "received";
                    chatMessages.append(`
                        <div class="message ${messageClass}">
                            <strong>${message.sender_name}</strong>
                            <p>${message.content}</p>
                            <small>${message.timestamp}</small>
                        </div>
                    `);
                });
                chatMessages.scrollTop(chatMessages[0].scrollHeight);
            }, 'json');
        }

        $(document).ready(function() {
            showMessages();

            $('#chatForm').submit(function(e) {
                e.preventDefault();

                const content = $('#messageInput').val();
                if (!content) return;

                $.post('send_message.php', {
                    receiver_id: <?php echo $admin_id; ?>,
                    content: content
                }, function(response) {
                    if (response.success) {
                        $('#messageInput').val('');
                        showMessages();
                    }
                }, 'json');
            });

            setInterval(showMessages, 3000);
        });
    </script>
</body>
</html>