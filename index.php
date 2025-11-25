<?php
// Tắt hiển thị lỗi PHP trong HTML (chỉ log vào file)
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// Load configuration và security helpers
require_once 'admincp/config/config.php';

// Load promotion helper
require_once 'includes/promotion_helper.php';

// Force HTTPS nếu cần thiết (không cần gọi vì đã gọi ở config.php)
// force_https();

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
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style-v1.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/chat.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/premium-overrides.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/header-fixes.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/newsletter-premium.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/footer-premium.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/danhmuc-premium.css?v=<?php echo time(); ?>">
    
</head>

<body <?php echo (!isset($_GET['quanly']) || $_GET['quanly'] == '') ? 'class="premium-home"' : ''; ?>>
    <div class="wrapper">
        <?php
        // Sử dụng header premium cho tất cả trang (bao gồm cả menu bên trong)
        include("pages/header-premium.php");
        include("pages/main.php");
        
        // Sử dụng newsletter chỉ cho trang chủ
        if (!isset($_GET['quanly']) || $_GET['quanly'] == '') {
            include("pages/newsletter-premium.php");
        }
        
        // Sử dụng footer premium cho tất cả trang
        include("pages/footer-premium.php");
        
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

    <?php include("pages/main/chat_widget.php"); ?>

    <!-- Custom Scripts -->
    <script src="js/script.js"></script>
    <?php
    if (defined('APP_ENV') && APP_ENV === 'local') {
        // Chỉ định endpoint cho môi trường local
        $chatApiEndpoint = 'api/chat.php';
    ?>
    <script>
        // Truyền endpoint từ PHP sang JavaScript
        window.CHAT_API_ENDPOINT = '<?php echo $chatApiEndpoint; ?>';
    </script>
    <script src="js/chat_new.js"></script>
    <?php
    } // End if local
    ?>
</body>

</html>