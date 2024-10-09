<?php
// admin_chat.php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat - MS Teams Style</title>
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
            max-width: 70%;
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
        <div class="sidebar">
            <div class="header">
                <h2>Admin Chat</h2>
            </div>
            <div class="chat-list" id="chatList">
                <!-- Chat list will be populated here -->
            </div>
        </div>
        <div class="chat-area">
            <div class="chat-header">
                <h3 id="currentCustomer">Select a chat</h3>
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
  $(document).ready(function() {
    let currentChatId = null;

    function populateChatList() {
        $.get('get_chats.php', function(chats) {
            const chatList = $('#chatList');
            chatList.empty();
            chats.forEach(chat => {
                console.log('Chat object:', chat); // Debug: Log each chat object
                const unreadBadge = chat.unread_count > 0 ? `<span class="unread-badge">${chat.unread_count}</span>` : '';
                const customerName = chat.customer_name || 'Unknown'; // Fallback if customer_name is undefined
                const lastMessage = chat.last_message || 'No messages yet';
                chatList.append(`
                    <div class="chat-item" data-id="${chat.id}">
                        <div>${customerName} ${unreadBadge}</div>
                        <small>${lastMessage}</small>
                    </div>
                `);
            });
            attachChatItemHandlers();
        }, 'json')
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error fetching chats:", textStatus, errorThrown);
        });
    }

    function showMessages(chatId) {
        $.get('get_messages.php', { other_user_id: chatId }, function(messages) {
            const chatMessages = $('#chatMessages');
            chatMessages.empty();
            messages.forEach(message => {
                console.log('Message object:', message); // Debug: Log each message object
                const messageClass = message.sender_id == <?php echo $_SESSION['user_id']; ?> ? "sent" : "received";
                const senderName = message.sender_name || 'Unknown'; // Fallback if sender_name is undefined
                chatMessages.append(`
                    <div class="message ${messageClass}">
                        <strong>${senderName}</strong>
                        <p>${message.content || ''}</p>
                        <small>${message.timestamp || ''}</small>
                    </div>
                `);
            });
            chatMessages.scrollTop(chatMessages[0].scrollHeight);
        }, 'json')
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error fetching messages:", textStatus, errorThrown);
        });
    }

    function attachChatItemHandlers() {
        $('.chat-item').click(function() {
            currentChatId = $(this).data('id');
            $('.chat-item').removeClass('active');
            $(this).addClass('active');
            const customerName = $(this).find('div').text().split(' ')[0]; // Get only the customer name
            $('#currentCustomer').text(customerName);
            showMessages(currentChatId);
            $(this).find('.unread-badge').remove();
        });
    }

    function sendMessage(content) {
        if (!currentChatId) {
            console.error("No chat selected");
            return;
        }

        $.post('send_message.php', {
            receiver_id: currentChatId,
            content: content
        }, function(response) {
            if (response.success) {
                $('#messageInput').val('');
                showMessages(currentChatId);
            } else {
                console.error("Error sending message:", response.error);
            }
        }, 'json')
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error sending message:", textStatus, errorThrown);
        });
    }

    populateChatList();

    $('#chatForm').submit(function(e) {
        e.preventDefault();
        const content = $('#messageInput').val();
        if (!content) return;
        sendMessage(content);
    });

    setInterval(function() {
        populateChatList();
        if (currentChatId) {
            showMessages(currentChatId);
        }
    }, 3000);
});
    </script>
</body>
</html>