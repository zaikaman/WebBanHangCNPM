<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once('../admincp/config/config.php');

function getStoreContext($mysqli) {
    $context = [];
    
    // Lấy thông tin sản phẩm
    $sql_sp = "SELECT sp.*, dm.name_sp as danhmuc_ten 
               FROM tbl_sanpham sp 
               LEFT JOIN tbl_danhmucqa dm ON sp.id_dm = dm.id_dm 
               WHERE sp.id_sp > 0";
    $query_sp = mysqli_query($mysqli, $sql_sp);
    
    $products = [];
    while($row = mysqli_fetch_array($query_sp)) {
        $products[] = [
            'id' => $row['id_sp'],
            'ten' => $row['ten_sp'],
            'ma' => $row['ma_sp'],
            'gia' => $row['gia_sp'],
            'soluong' => $row['so_luong_con_lai'],
            'mota' => $row['tom_tat'],
            'danhmuc' => $row['id_dm'],
            'danhmuc_ten' => $row['danhmuc_ten']
        ];
    }
    
    // Nhóm sản phẩm theo danh mục
    $productsByCategory = [];
    foreach($products as $product) {
        if(!isset($productsByCategory[$product['danhmuc']])) {
            $productsByCategory[$product['danhmuc']] = [
                'ten_danhmuc' => $product['danhmuc_ten'],
                'san_pham' => []
            ];
        }
        $productsByCategory[$product['danhmuc']]['san_pham'][] = $product;
    }
    $context['products'] = $productsByCategory;
    
    return $context;
}

function saveChat($mysqli, $message, $response, $sessionId = null) {
    $message = mysqli_real_escape_string($mysqli, $message);
    $response = mysqli_real_escape_string($mysqli, $response);
    $email = isset($_SESSION['email']) ? mysqli_real_escape_string($mysqli, $_SESSION['email']) : NULL;
    $sessionIdEscaped = $sessionId ? mysqli_real_escape_string($mysqli, $sessionId) : NULL;
    
    $sql = "INSERT INTO tbl_chat_history (email, message, response, session_id) 
            VALUES (" . ($email ? "'$email'" : "NULL") . ", '$message', '$response', " . ($sessionIdEscaped ? "'$sessionIdEscaped'" : "NULL") . ")";
    mysqli_query($mysqli, $sql);
}

function getRecentChat($mysqli, $sessionId = null, $limit = 5) {
    $email = isset($_SESSION['email']) ? mysqli_real_escape_string($mysqli, $_SESSION['email']) : NULL;
    $sessionIdEscaped = $sessionId ? mysqli_real_escape_string($mysqli, $sessionId) : NULL;
    
    $sql = "SELECT message, response FROM tbl_chat_history WHERE 1=1 ";
    
    // Ưu tiên session_id nếu có
    if($sessionIdEscaped) {
        $sql .= "AND session_id = '$sessionIdEscaped' ";
    } else if($email) {
        $sql .= "AND email = '$email' ";
    }
    
    $sql .= "ORDER BY created_at DESC LIMIT $limit";
    
    $result = mysqli_query($mysqli, $sql);
    $history = [];
    while($row = mysqli_fetch_array($result)) {
        $history[] = [
            'user' => $row['message'],
            'ai' => $row['response']
        ];
    }
    return array_reverse($history);
}

$API_KEY = env('GEMINI_API_KEY');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $message = $data['message'] ?? '';
    $sessionId = $data['sessionId'] ?? null;

    if (empty($message)) {
        http_response_code(400);
        echo json_encode(['error' => 'Message is required']);
        exit;
    }

    $context = getStoreContext($mysqli);
    $history = getRecentChat($mysqli, $sessionId);
    
    $initialPrompt = "Bạn là trợ lý AI của 7TCC - Thương hiệu thời trang thể thao được phát triển bởi nhóm 8 sinh viên Đại học Sài Gòn.

Thông tin về cửa hàng:
- Website: https://7tcc.great-site.net
- Địa chỉ: 273 An Dương Vương – Phường 3 – Quận 5
- Hotline: 0909888888
- Email: zaikaman123@gmail.com

Danh sách sản phẩm theo danh mục:\n";

    foreach($context['products'] as $cat_id => $category) {
        $initialPrompt .= "\n{$category['ten_danhmuc']}:\n";
        foreach($category['san_pham'] as $product) {
            $initialPrompt .= "- {$product['ten']}\n";
            $initialPrompt .= "  + Mã SP: {$product['ma']}\n";
            $initialPrompt .= "  + Giá: " . number_format($product['gia'], 0, ',', '.') . "đ\n";
            $initialPrompt .= "  + Số lượng còn lại: {$product['soluong']}\n";
            $initialPrompt .= "  + Mô tả: {$product['mota']}\n";
        }
    }

    $initialPrompt .= "\nChính sách của cửa hàng:
- Đổi trả trong vòng 30 ngày nếu sản phẩm còn nguyên tem mác
- Miễn phí vận chuyển cho đơn hàng từ 500.000đ
- Thanh toán: COD, chuyển khoản, Momo
- Bảo hành sản phẩm 6 tháng với lỗi từ nhà sản xuất

Lịch sử trò chuyện gần đây:\n";

    foreach($history as $chat) {
        $initialPrompt .= "Khách hàng: {$chat['user']}\n";
        $initialPrompt .= "7TCC: {$chat['ai']}\n\n";
    }

    $initialPrompt .= "\nBạn có thể:
- Tư vấn chi tiết về các sản phẩm trên (giá, số lượng, mô tả)
- Hướng dẫn cách chọn size
- Giải đáp thắc mắc về chính sách đổi trả, bảo hành
- Tư vấn phương thức thanh toán và vận chuyển
- Hỗ trợ các vấn đề về đơn hàng

Hãy trả lời bằng Tiếng Việt một cách thân thiện và chuyên nghiệp. Nếu không chắc chắn về thông tin nào, hãy đề xuất khách hàng liên hệ trực tiếp qua hotline.

Khách hàng: " . $message;

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $API_KEY;
    
    $postData = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $initialPrompt]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $responseData = json_decode($response, true);
        $aiResponse = $responseData['candidates'][0]['content']['parts'][0]['text'];
        saveChat($mysqli, $message, $aiResponse, $sessionId);
        echo $response;
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to get response from Gemini API']);
    }
}
?>