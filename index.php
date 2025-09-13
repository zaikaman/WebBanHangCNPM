<?php
// Load configuration và security helpers
require_once 'admincp/config/config.php';

// Force HTTPS nếu cần thiết
force_https();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://web7tcc-a9aaa5d624b4.herokuapp.com/" />
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <title>web7tcc</title>
    <meta name="description" content="Khám phá những sản phẩm quần áo thể thao chất lượng tại web7tcc" />

    <!-- Link Font Style -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=STIX+Two+Text:ital,wght@0,400;0,500;0,600;0,700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQpeoYpPsrHbQ/qOUu4Tpvb9Kdh9jjp/aYY8bTjFNE1xQ+Kbh" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style-v1.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/chat.css?v=<?php echo time(); ?>">
    
    <!-- Force center navigation -->
    <style>
        .menu_content {
            justify-content: center !important;
            display: flex !important;
            align-items: center !important;
            gap: 5px !important;
        }
        
        .menu .menu_content {
            justify-content: center !important;
        }
        
        .menu_items {
            min-width: 80px !important;
            flex: 0 0 auto !important;
            width: auto !important;
            margin: 0 5px !important;
        }
        
        .menu_items * {
            font-size: 16px !important;
            font-weight: 600 !important;
        }
        
        .item {
            padding: 0 15px !important;
        }
        
        /* Improve banner quality */
        .carousel {
            height: 400px !important;
            overflow: hidden !important;
        }
        
        .carousel-inner img {
            height: 400px !important;
            width: 100% !important;
            object-fit: cover !important;
            object-position: center !important;
        }
        
        .slide img {
            height: 400px !important;
            width: 100% !important;
            object-fit: cover !important;
            object-position: center !important;
        }
        
        @media (max-width: 768px) {
            .carousel {
                height: 280px !important;
            }
            
            .carousel-inner img,
            .slide img {
                height: 280px !important;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php
        include("admincp/config/config.php");
        include("pages/header.php");
        include("pages/menu.php");
        include("pages/main.php");
        include("pages/footer.php");
        include("pages/anchor.php");
        ?>
    </div>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- jQuery, Popper, Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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

    <!-- Custom Scripts -->
    <script src="js/script.js"></script>
    <script src="js/chat_new.js"></script>
</body>

</html>
