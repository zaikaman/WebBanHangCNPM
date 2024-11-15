<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("admincp/config/config.php");
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <link rel="canonical" href="https://web7tcc-a9aaa5d624b4.herokuapp.com/" />
    <title>web7tcc</title>
    <meta name="description" content="Khám phá những sản phẩm quần áo thể thao chất lượng tại web7tcc" />

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Preconnect to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=STIX+Two+Text:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style-v1.css">
    <link rel="stylesheet" href="css/chat.css">
</head>

<body>
    <div class="wrapper">
        <?php
        include("pages/header.php");
        include("pages/menu.php");
        ?>
        
        <div class="main_content">
            <?php include("pages/main.php"); ?>
        </div>
        
        <?php include("pages/footer.php"); ?>
    </div>

    <!-- Chat UI -->
    <div class="chat-toggle">
        <ion-icon name="chatbubbles-outline" style="font-size: 24px;"></ion-icon>
    </div>

    <div class="chat-container">
        <div class="chat-header">
            <span>Chat với AI</span>
            <ion-icon name="close-outline" style="cursor: pointer;" id="close-chat"></ion-icon>
        </div>
        <div class="chat-messages" id="chat-messages"></div>
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="Nhập tin nhắn...">
            <button id="send-message">Gửi</button>
        </div>
    </div>

    <!-- Scripts -->
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- jQuery, Popper, Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script src="js/script.js"></script>
    <script src="js/chat.js"></script>
    <script src="js/ajax-handler.js"></script>
</body>
</html>

