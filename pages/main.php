<?php
header('Content-Encoding: gzip');
header('Cache-Control: private, max-age=3600');
ob_start("ob_gzhandler");

// Kiểm tra AJAX request
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
   strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Chỉ trả về nội dung chính
    include("main/content.php");
} else {
    // Load toàn bộ layout với wrapper
    echo '<div id="main">';
    include("main/content.php");
    echo '</div>';
}
?>
