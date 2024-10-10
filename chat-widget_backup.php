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
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Chatbot header styles */
    .chatbot-header {
      background-color: #0077b6;
      color: #ffffff;
      padding: 12px 16px;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
      transition: background-color 0.3s ease, width 0.3s ease, height 0.3s ease;
    }

    .chatbot-header:hover {
      background-color: #005a88;
    }

    .chatbot-header.expanded {
      width: 100%;
      height: auto;
      border-radius: 12px;
      justify-content: flex-start;
    }

    .chatbot-icon {
      font-size: 24px;
    }

    .chatbot-header-title {
      font-size: 16px;
      font-weight: 600;
      margin: 0;
    }

    /* Chatbot content area styles */
    .chatbot-content {
      padding: 16px;
      display: none;
    }

    .chatbot-content h3 {
      font-size: 18px;
      margin-top: 0;
    }

    /* Chatbot messages container styles */
    .chatbot-messages {
      max-height: 300px;
      overflow-y: auto;
      margin-bottom: 12px;
    }

    /* Individual chatbot message styles */
    .chatbot-message {
      padding: 10px 12px;
      border-radius: 8px;
      margin-bottom: 10px;
      cursor: pointer;
      font-size: 14px;
    }

    .chatbot-message:hover {
      background-color: #f0f0f0;
    }

    .chatbot-message.user {
      background-color: #e6f2ff;
      color: #0077b6;
    }

    .chatbot-message.bot {
      background-color: #f0f0f0;
    }

    /* Chatbot input field styles */
    .chatbot-input {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #cccccc;
      border-radius: 6px;
      box-sizing: border-box;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="chatbot-widget">
    <div class="chatbot-header">
      <div class="chatbot-icon">💬</div>
      <h3 class="chatbot-header-title">How can I assist you?</h3>
    </div>
    <div class="chatbot-content">
      <h3>How can I help you today?</h3>
      <div class="chatbot-messages">
        <div class="chatbot-message bot" data-response="I can help you with the order process. What specific questions do you have?">
          How to order
        </div>
        <div class="chatbot-message bot" data-response="Sure, I'd be happy to explain our return and exchange policy. What would you like to know?">
          Returns and exchanges
        </div>
        <div class="chatbot-message bot" data-response="Okay, let me provide some details about our shipping options and delivery timelines.">
          Shipping information
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

    // Toggle the visibility and size of the chatbot header on click
    chatbotHeader.addEventListener('click', () => {
      chatbotHeader.classList.toggle('expanded');
      chatbotContent.style.display = chatbotContent.style.display === 'none' ? 'block' : 'none';
    });

    // Close the chatbot widget when clicking outside of it
    document.addEventListener('click', (event) => {
      if (!chatbotWidget.contains(event.target)) {
        chatbotContent.style.display = 'none';
        chatbotHeader.classList.remove('expanded');
      }
    });

    // Handle user clicks on pre-defined messages
    chatbotMessages.addEventListener('click', (event) => {
      if (event.target.classList.contains('chatbot-message')) {
        const response = event.target.getAttribute('data-response');
        const botMessage = document.createElement('div');
        botMessage.classList.add('chatbot-message', 'bot');
        botMessage.textContent = response;
        chatbotMessages.appendChild(botMessage);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
      }
    });

    // Handle user input and bot response
    chatbotInput.addEventListener('keyup', (event) => {
      if (event.key === 'Enter') {
        const userMessage = document.createElement('div');
        userMessage.classList.add('chatbot-message', 'user');
        userMessage.textContent = chatbotInput.value;
        chatbotMessages.appendChild(userMessage);
        chatbotInput.value = '';

        // Simulate a response from the bot
        setTimeout(() => {
          const botMessage = document.createElement('div');
          botMessage.classList.add('chatbot-message', 'bot');
          botMessage.textContent = 'Thank you for your message. I will do my best to assist you.';
          chatbotMessages.appendChild(botMessage);
          chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }, 1000);
      }
    });
  </script>
</body>
</html>