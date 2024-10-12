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
    <title>E-Commerce Customer Support</title>
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f3f4f6;
            --text-color: #333;
            --border-color: #e1e4e8;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .chat-widget-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .chat-widget-icon:hover {
            transform: scale(1.1);
        }

        .chat-widget {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 350px;
            height: 500px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: none;
            flex-direction: column;
            background-color: white;
            border: 1px solid var(--border-color);
            z-index: 999;
        }

        .chat-widget-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
        }

        .chat-messages {
            flex-grow: 1;
            padding: 15px;
            overflow-y: auto;
            background-color: var(--secondary-color);
        }

        .message {
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 80%;
            line-height: 1.4;
            position: relative;
        }

        .message.received {
            align-self: flex-start;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            background-color: #635b6b;
            color: white;
        }

        .message.sent {
            background-color: var(--primary-color);
            color: white;
            align-self: flex-end;
            margin-left: auto;
        }

        .chat-input {
            display: flex;
            padding: 15px;
            background-color: white;
            border-top: 1px solid var(--border-color);
        }

        .chat-input input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            font-size: 14px;
        }

        .chat-input button {
            margin-left: 10px;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .chat-input button:hover {
            background-color: #3a7bc8;
        }
    </style>
</head>
<body>

<div class="chat-widget-icon" id="chatWidgetIcon">
    <img src="assets/mist-logo-withoutname.png" alt="Chat Icon" style="width: 60px; height: 60px;">
</div>

<div class="chat-widget" id="chatWidget">
    <div class="chat-widget-header">
        <h3>I.M Live Support</h3>
    </div>
    <div class="chat-messages" id="chatMessages"></div>
    <div class="chat-input">
        <input type="text" id="messageInput" placeholder="Type a message..." required>
        <button id="sendButton">Send</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatWidgetIcon = document.getElementById('chatWidgetIcon');
    const chatWidget = document.getElementById('chatWidget');
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');

    const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
    const adminId = <?php echo $admin_id; ?>;
    const userId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;

    let currentQuestion = 0;
    const ecommerceQuestions = [
        { question: "Welcome to Innocuous Mist ChatBot! How can I assist you today?", options: ["Return policy", "How to Order","Log-in to chat with Admin"] },
        { question: "Please select a category:", options: ["Vapes", "Juice", "Disposables", "Accessories"] },
        { question: "What specific information do you need?", options: ["Price", "Availability", "Shipping", "Reviews"] }
    ];

    function toggleChatWidget() {
        chatWidget.style.display = chatWidget.style.display === 'none' ? 'flex' : 'none';
        if (chatWidget.style.display === 'flex' && chatMessages.children.length === 0) {
            if (!isLoggedIn) {
                showNextQuestion();
            } else {
                showMessages();
            }
        }
    }

    chatWidgetIcon.addEventListener('click', toggleChatWidget);

    function addMessage(content, isReceived = true) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', isReceived ? 'received' : 'sent');
        messageDiv.textContent = content;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function showNextQuestion() {
        if (currentQuestion < ecommerceQuestions.length) {
            const question = ecommerceQuestions[currentQuestion];
            addMessage(question.question);
            setTimeout(() => {
                question.options.forEach(option => {
                    addMessage(option);
                });
            }, 500);
        } else {
            addMessage("Thank you for your inquiries. For more detailed assistance, please log in or create an account.");
        }
    }

    function handleUserInput(input) {
        if (!isLoggedIn) {
            addMessage(input, false);
            currentQuestion++;
            setTimeout(showNextQuestion, 1000);
        } else {
            sendMessage(input);
        }
    }

    function sendMessageHandler() {
        const message = messageInput.value.trim();
        if (message) {
            handleUserInput(message);
            messageInput.value = '';
        }
    }

    sendButton.addEventListener('click', sendMessageHandler);

    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessageHandler();
        }
    });

    if (isLoggedIn) {
        function showMessages() {
            $.getJSON('ChatUse/get_messages.php', { other_user_id: adminId }, function(messages) {
                $('#chatMessages').empty();
                messages.forEach(message => {
                    const messageClass = message.sender_id == userId ? "sent" : "received";
                    $('#chatMessages').append(`
                        <div class="message ${messageClass}">
                            <p>${message.content}</p>
                            <small>${message.timestamp}</small>
                        </div>
                    `);
                });
                $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error fetching messages:", textStatus, errorThrown);
            });
        }

        function sendMessage(content) {
            $.post('ChatUse/send_message.php', { receiver_id: adminId, content: content }, function(response) {
                if (response.success) {
                    showMessages();
                }
            }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error sending message:", textStatus, errorThrown);
            });
        }

        showMessages();
        setInterval(showMessages, 3000);
    }
});
</script>

</body>
</html>