document.addEventListener('DOMContentLoaded', function() {
    const chatToggle = document.querySelector('.chat-toggle');
    const chatContainer = document.querySelector('.chat-container');
    const closeChat = document.querySelector('#close-chat');
    const sendButton = document.querySelector('#send-message');
    const userInput = document.querySelector('#user-input');
    const chatMessages = document.querySelector('#chat-messages');

    // Khởi tạo chat
    let isFirstMessage = true;

    chatToggle.addEventListener('click', () => {
        chatContainer.style.display = 'flex';
        chatToggle.style.display = 'none';
        if (isFirstMessage) {
            appendMessage("Xin chào! Tôi là trợ lý AI của 7TCC. Tôi có thể giúp gì cho bạn?", 'ai');
            isFirstMessage = false;
        }
    });

    closeChat.addEventListener('click', () => {
        chatContainer.style.display = 'none';
        chatToggle.style.display = 'flex';
    });

    // Xử lý gửi tin nhắn khi click nút gửi
    sendButton.addEventListener('click', sendMessage);

    // Xử lý gửi tin nhắn khi nhấn Enter
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Hàm gửi tin nhắn
    async function sendMessage() {
        const message = userInput.value.trim();
        if (!message) return;

        // Hiển thị tin nhắn người dùng
        appendMessage(message, 'user');
        userInput.value = '';

        try {
            const response = await fetch('api/chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message: message })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            const aiResponse = data.candidates[0].content.parts[0].text;
            
            // Xử lý và hiển thị tin nhắn AI
            appendMessage(aiResponse, 'ai');

        } catch (error) {
            console.error('Error:', error);
            appendMessage('Xin lỗi, đã có lỗi xảy ra. Vui lòng thử lại sau.', 'ai');
        }
    }

    // Hàm thêm tin nhắn vào khung chat
    function appendMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;
        
        // Xử lý định dạng tin nhắn
        let formattedText = text
            // Chuyển URL thành links
            .replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank">$1</a>')
            // Xử lý xuống dòng
            .replace(/\n/g, '<br>');

        messageDiv.innerHTML = formattedText;
        chatMessages.appendChild(messageDiv);
        
        // Cuộn xuống tin nhắn mới nhất
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});