<?php
// customer_chat_widget.php
// session_start();
require_once 'conf/config.php';

$isLoggedIn = isset($_SESSION['user_id']) && !$_SESSION['is_admin'];
$admin_id = $conn->query("SELECT id FROM users WHERE is_admin = 1")->fetch_assoc()['id'];

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Chat Widget</title>
    <style>
        /* Widget Icon */
        .chat-widget-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #464775;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 24px;
        }

        /* Chat Widget */
        .chat-widget {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 300px;
            max-height: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: none;
            flex-direction: column;
            background-color: white;
            border: 1px solid #e1dfdd;
        }

        /* Chat Header */
        .chat-widget-header {
            background-color: #464775;
            color: white;
            padding: 10px;
            text-align: center;
        }

        /* Chat Messages */
        .chat-messages {
            flex-grow: 1;
            padding: 10px;
            overflow-y: auto;
        }

        /* Message Styles */
        .message {
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 5px;
            max-width: 80%;
        }

        .message.received {
            background-color: #f3f2f1;
            align-self: flex-start;
        }

        .message.sent {
            background-color: #e1dfdd;
            align-self: flex-end;
            margin-left: auto;
        }

        /* Chat Input */
        .chat-input {
            display: flex;
            padding: 10px;
            background-color: #f3f2f1;
            border-top: 1px solid #e1dfdd;
        }

        .chat-input input {
            flex-grow: 1;
            padding: 8px;
            border: 1px solid #e1dfdd;
            border-radius: 5px;
        }

        .chat-input button {
            margin-left: 10px;
            padding: 8px;
            background-color: #464775;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Chat Widget Icon -->
<div class="chat-widget-icon" id="chatWidgetIcon">💬</div>

<!-- Chat Widget -->
<div class="chat-widget" id="chatWidget">
    <div class="chat-widget-header">
        <h3>Chat</h3>
    </div>
    <div class="chat-messages" id="chatMessages">
        <?php if ($isLoggedIn): ?>
            <!-- Logged-in user chat -->
            <div id="chatContent"></div>
        <?php else: ?>
            <!-- Static bot messages for guest users -->
            <div class="message received">
                <p>Hi, I’m a support bot! How can I help you today?</p>
            </div>
            <div class="message received">
                <p>Please <a href="../login.php">login</a> to chat with an admin.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($isLoggedIn): ?>
    <!-- Input form only for logged-in users -->
    <div class="chat-input">
        <form id="chatForm">
            <input type="text" id="messageInput" placeholder="Type a message..." required>
            <button type="submit">Send</button>
        </form>
    </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Toggle chat widget
    const chatWidgetIcon = document.getElementById('chatWidgetIcon');
    const chatWidget = document.getElementById('chatWidget');

    chatWidgetIcon.addEventListener('click', () => {
        chatWidget.style.display = chatWidget.style.display === 'none' ? 'flex' : 'none';
    });

    <?php if ($isLoggedIn): ?>
    // Fetch and show messages for logged-in users
    function showMessages() {
        $.get('ChatUse/get_messages.php', { other_user_id: <?php echo $admin_id; ?> }, function(messages) {
            const chatMessages = $('#chatContent');
            chatMessages.empty();
            messages.forEach(message => {
                const messageClass = message.sender_id == <?php echo $_SESSION['user_id']; ?> ? "sent" : "received";
                chatMessages.append(`
                    <div class="message ${messageClass}">
                        <p>${message.content}</p>
                        <small>${message.timestamp}</small>
                    </div>
                `);
            });
            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
        }, 'json');
    }

    $(document).ready(function() {
        showMessages();
        $('#chatForm').submit(function(e) {
            e.preventDefault();
            const content = $('#messageInput').val();
            if (!content) return;

            $.post('ChatUse/send_message.php', { receiver_id: <?php echo $admin_id; ?>, content: content }, function(response) {
                if (response.success) {
                    $('#messageInput').val('');
                    showMessages();
                }
            }, 'json');
        });

        setInterval(showMessages, 3000); // Update messages every 3 seconds
    });
    <?php endif; ?>
</script>

</body>
</html>
