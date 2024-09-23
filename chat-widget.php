<!DOCTYPE html>
<html>
<head>
  <title>Chatbot Widget</title>
  <style>
    /* Chatbot widget container styles */
    .chatbot-widget {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 350px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      font-family: Arial, sans-serif;
    }

    /* Chatbot header styles */
    .chatbot-header {
      background-color: #007bff;
      color: #fff;
      padding: 10px;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
    }

    .chatbot-header h3 {
      margin: 0;
    }

    .chatbot-icon {
      font-size: 24px;
      margin-right: 10px;
    }

    /* Chatbot content area styles */
    .chatbot-content {
      padding: 15px;
      display: none;
    }

    /* Chatbot messages container styles */
    .chatbot-messages {
      max-height: 300px;
      overflow-y: auto;
      margin-bottom: 10px;
    }

    /* Individual chatbot message styles */
    .chatbot-message {
      background-color: #808080;
      padding: 10px;
      border-radius: 10px;
      margin-bottom: 10px;
    }

    /* Chatbot input field styles */
    .chatbot-input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
  </style>
</head>
<body>
  <div class="chatbot-widget">
    <div class="chatbot-header">
      <div class="chatbot-icon">💬</div>
      <h3>How can I assist you?</h3>
    </div>
    <div class="chatbot-content">
      <div class="chatbot-messages">
        <div class="chatbot-message">
          Welcome to our e-commerce website! How can I help you today?
        </div>
      </div>
      <input type="text" class="chatbot-input" placeholder="Type your message..." />
    </div>
  </div>

  <script>
    // Add interactivity to the chatbot widget
    const chatbotWidget = document.querySelector('.chatbot-widget');
    const chatbotHeader = document.querySelector('.chatbot-header');
    const chatbotContent = document.querySelector('.chatbot-content');
    const chatbotInput = document.querySelector('.chatbot-input');
    const chatbotMessages = document.querySelector('.chatbot-messages');

    // Toggle the visibility of the chatbot content on header click
    chatbotHeader.addEventListener('click', () => {
      chatbotContent.style.display = chatbotContent.style.display === 'none' ? 'block' : 'none';
    });

    // Close the chatbot widget when clicking outside of it
    document.addEventListener('click', (event) => {
      if (!chatbotWidget.contains(event.target)) {
        chatbotContent.style.display = 'none';
      }
    });

    // Handle user input and bot response
    chatbotInput.addEventListener('keyup', (event) => {
      if (event.key === 'Enter') {
        const userMessage = document.createElement('div');
        userMessage.classList.add('chatbot-message');
        userMessage.textContent = chatbotInput.value;
        chatbotMessages.appendChild(userMessage);
        chatbotInput.value = '';

        // Simulate a response from the bot
        setTimeout(() => {
          const botMessage = document.createElement('div');
          botMessage.classList.add('chatbot-message');
          botMessage.textContent = 'Thank you for your message. I will do my best to assist you.';
          chatbotMessages.appendChild(botMessage);
          chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }, 1000);
      }
    });
  </script>
</body>
</html>