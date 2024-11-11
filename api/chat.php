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
    $sql_sp = "SELECT * FROM tbl_sanpham WHERE id_sp > 0";
    $query_sp = mysqli_query($mysqli, $sql_sp);
    
    $products = [];
    while($row = mysqli_fetch_array($query_sp)) {
        $products[] = [
            'id' => $row['id_sp'],
            'ten' => $row['tensanpham'],
            'ma' => $row['masp'],
            'gia' => $row['giasp'],
            'soluong' => $row['soluong'],
            'mota' => $row['tomtat']
        ];
    }
    $context['products'] = $products;
    
    // Lấy thông tin liên hệ
    $sql_lh = "SELECT * FROM tbl_lienhe WHERE id=1";
    $query_lh = mysqli_query($mysqli, $sql_lh);
    if($row = mysqli_fetch_array($query_lh)) {
        $context['contact'] = $row['thongtinlienhe'];
    }

    // Lấy danh mục sản phẩm
    $sql_dm = "SELECT * FROM tbl_danhmucqa";
    $query_dm = mysqli_query($mysqli, $sql_dm);
    $categories = [];
    while($row = mysqli_fetch_array($query_dm)) {
        $categories[] = $row['name_sp'];
    }
    $context['categories'] = $categories;
    
    return $context;
}

function saveChat($mysqli, $message, $response) {
    $message = mysqli_real_escape_string($mysqli, $message);
    $response = mysqli_real_escape_string($mysqli, $response);
    $email = isset($_SESSION['email']) ? mysqli_real_escape_string($mysqli, $_SESSION['email']) : NULL;
    
    $sql = "INSERT INTO tbl_chat_history (email, message, response) 
            VALUES (" . ($email ? "'$email'" : "NULL") . ", '$message', '$response')";
    mysqli_query($mysqli, $sql);
}

function getRecentChat($mysqli, $limit = 5) {
    $email = isset($_SESSION['email']) ? mysqli_real_escape_string($mysqli, $_SESSION['email']) : NULL;
    
    $sql = "SELECT message, response FROM tbl_chat_history ";
    if($email) {
        $sql .= "WHERE email = '$email' ";
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

$API_KEY = 'AIzaSyCsrBVCvzZcw99BwCTF3mkEAuCGyfewmCc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $message = $data['message'] ?? '';

    if (empty($message)) {
        http_response_code(400);
        echo json_encode(['error' => 'Message is required']);
        exit;
    }

    $context = getStoreContext($mysqli);
    $history = getRecentChat($mysqli);
    
    $initialPrompt = "Bạn là trợ lý AI của 7TCC - Thương hiệu thời trang thể thao được phát triển bởi nhóm 8 sinh viên Đại học Sài Gòn.

Thông tin về cửa hàng:
- Địa chỉ: 273 An Dương Vương – Phường 3 – Quận 5
- Hotline: 0938688079
- Email: support@7tcc.vn

Danh mục sản phẩm: " . implode(", ", $context['categories']) . "

Danh sách sản phẩm hiện có:
";

    foreach($context['products'] as $product) {
        $initialPrompt .= "- {$product['ten']}: {$product['mota']} - Giá: " . number_format($product['gia'], 0, ',', '.') . "đ\n";
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
- Tư vấn chi tiết về các sản phẩm trên
- Hướng dẫn cách chọn size
- Giải đáp thắc mắc về chính sách đổi trả, bảo hành
- Tư vấn phương thức thanh toán và vận chuyển
- Hỗ trợ các vấn đề về đơn hàng

Hãy trả lời bằng Tiếng Việt một cách thân thiện và chuyên nghiệp. Nếu không chắc chắn về thông tin nào, hãy đề xuất khách hàng liên hệ trực tiếp qua hotline.

Khách hàng: " . $message;

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=" . $API_KEY;
    
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
        saveChat($mysqli, $message, $aiResponse);
        echo $response;
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to get response from Gemini API']);
    }
}
?>