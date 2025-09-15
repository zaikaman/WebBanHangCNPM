<?php if (APP_ENV === 'local') { ?>
    <div class="chat-toggle">
        <ion-icon name="chatbubbles-outline" style="font-size: 24px;"></ion-icon>
    </div>

    <div class="chat-container">
        <div class="chat-header">
            <span>Chat với AI</span>
            <div class="chat-header-buttons">
                <button id="new-chat" title="Cuộc trò chuyện mới">
                    <ion-icon name="add-outline" style="font-size: 18px;"></ion-icon>
                </button>
                <ion-icon name="close-outline" style="cursor: pointer; font-size: 20px;" id="close-chat"></ion-icon>
            </div>
        </div>
        <div class="chat-messages" id="chat-messages">
        </div>
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="Nhập tin nhắn...">
            <button id="send-message">Gửi</button>
        </div>
    </div>
<?php } ?>