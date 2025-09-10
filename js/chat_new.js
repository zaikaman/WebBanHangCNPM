document.addEventListener('DOMContentLoaded', function() {
 
    // Elements
    const chatToggle = document.querySelector('.chat-toggle');
    const chatContainer = document.querySelector('.chat-container');
    const closeChat = document.querySelector('#close-chat');
    const sendButton = document.querySelector('#send-message');
    const userInput = document.querySelector('#user-input');
    const chatMessages = document.querySelector('#chat-messages');
    const newChatButton = document.querySelector('#new-chat');

    // Variables
    let sessionId;
    let isFirstMessage = true;

    // Functions
    function generateSessionId() {
        return 'chat_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    function getSessionId() {
        let id = localStorage.getItem('chatSessionId');
        if (!id) {
            id = generateSessionId();
            localStorage.setItem('chatSessionId', id);
        }
        return id;
    }

    function getChatHistory() {
        const history = localStorage.getItem('chatHistory_' + sessionId);
        return history ? JSON.parse(history) : [];
    }

    function saveChatHistory() {
        const messages = [];
        const messageElements = chatMessages.querySelectorAll('.message');
        
        messageElements.forEach(element => {
            const isUser = element.classList.contains('user-message');
            messages.push({
                text: element.textContent || element.innerText,
                sender: isUser ? 'user' : 'ai',
                timestamp: Date.now()
            });
        });
        
        localStorage.setItem('chatHistory_' + sessionId, JSON.stringify(messages));
    }

    function loadChatHistory() {
        const history = getChatHistory();
        
        if (history.length > 0) {
            chatMessages.innerHTML = '';
            history.forEach(message => {
                appendMessage(message.text, message.sender);
            });
            isFirstMessage = false;
        }
    }

    function clearChatHistory() {
        localStorage.removeItem('chatHistory_' + sessionId);
        Object.keys(localStorage).forEach(key => {
            if (key.startsWith('chatHistory_')) {
                localStorage.removeItem(key);
            }
        });
    }

    function appendMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;
        
        const formattedText = text
            .replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank">$1</a>')
            .replace(/\n/g, '<br>');

        messageDiv.innerHTML = formattedText;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    async function sendMessage() {
        const message = userInput.value.trim();
        if (!message) return;

        appendMessage(message, 'user');
        userInput.value = '';
        saveChatHistory();

        try {
            const response = await fetch('api/chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ 
                    message: message,
                    sessionId: sessionId 
                })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            const aiResponse = data.candidates[0].content.parts[0].text;
            
            appendMessage(aiResponse, 'ai');
            saveChatHistory();

        } catch (error) {
            console.error('Error:', error);
            appendMessage('Xin lỗi, đã có lỗi xảy ra. Vui lòng thử lại sau.', 'ai');
            saveChatHistory();
        }
    }

    // Initialize
    sessionId = getSessionId();
    loadChatHistory();

    // Event listeners
    if (chatToggle) {
        chatToggle.addEventListener('click', () => {
            chatContainer.style.display = 'flex';
            chatToggle.style.display = 'none';
            
            const chatHistory = getChatHistory();
            if (chatHistory.length === 0 && isFirstMessage) {
                appendMessage("Xin chào! Tôi là trợ lý AI của 7TCC. Tôi có thể giúp gì cho bạn?", 'ai');
                saveChatHistory();
                isFirstMessage = false;
            }
        });
    }

    if (closeChat) {
        closeChat.addEventListener('click', () => {
            chatContainer.style.display = 'none';
            chatToggle.style.display = 'flex';
        });
    }

    if (newChatButton) {
        newChatButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            if (confirm('Bạn có chắc chắn muốn bắt đầu cuộc trò chuyện mới? Lịch sử chat hiện tại sẽ bị xóa.')) {
                clearChatHistory();
                chatMessages.innerHTML = '';
                sessionId = generateSessionId();
                localStorage.setItem('chatSessionId', sessionId);
                isFirstMessage = true;
                appendMessage("Xin chào! Tôi là trợ lý AI của 7TCC. Tôi có thể giúp gì cho bạn?", 'ai');
                saveChatHistory();
            }
        });
    } else {
        console.error('New chat button not found');
    }

    if (sendButton) {
        sendButton.addEventListener('click', sendMessage);
    }

    if (userInput) {
        userInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
    }
});
