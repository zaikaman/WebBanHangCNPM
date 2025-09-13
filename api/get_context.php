<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Cho phép tất cả các domain gọi, bao gồm cả worker

require_once('../admincp/config/config.php');

// Hàm lấy thông tin sản phẩm, cửa hàng
function getStoreContext($mysqli) {
    $context = [];
    
    // Lấy thông tin sản phẩm
    $sql_sp = "SELECT sp.*, dm.name_sp as danhmuc_ten 
               FROM tbl_sanpham sp 
               LEFT JOIN tbl_danhmucqa dm ON sp.id_dm = dm.id_dm 
               WHERE sp.id_sp > 0";
    $query_sp = mysqli_query($mysqli, $sql_sp);
    
    $products = [];
    if ($query_sp) {
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
    }
    
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

// Hàm lấy lịch sử chat
function getRecentChat($mysqli, $sessionId = null, $limit = 5) {
    $sessionIdEscaped = $sessionId ? mysqli_real_escape_string($mysqli, $sessionId) : NULL;
    
    $sql = "SELECT message, response FROM tbl_chat_history WHERE 1=1 ";
    
    if($sessionIdEscaped) {
        $sql .= "AND session_id = '$sessionIdEscaped' ";
    } else {
        // Nếu không có session id, không trả về lịch sử để tránh nhầm lẫn
        return [];
    }
    
    $sql .= "ORDER BY created_at DESC LIMIT $limit";
    
    $result = mysqli_query($mysqli, $sql);
    $history = [];
    if ($result) {
        while($row = mysqli_fetch_array($result)) {
            $history[] = [
                'user' => $row['message'],
                'ai' => $row['response']
            ];
        }
    }
    return array_reverse($history);
}

// --- Main Logic ---

// Lấy sessionId từ query string, ví dụ: /api/get_context.php?sessionId=xyz
$sessionId = isset($_GET['sessionId']) ? $_GET['sessionId'] : null;

// Lấy toàn bộ dữ liệu
$storeContext = getStoreContext($mysqli);
$chatHistory = getRecentChat($mysqli, $sessionId);

// Gộp lại thành một object để trả về
$response_data = [
    'store_context' => $storeContext,
    'chat_history' => $chatHistory,
    'static_info' => [
        'store_name' => '7TCC - Thương hiệu thời trang thể thao',
        'developed_by' => 'nhóm 8 sinh viên Đại học Sài Gòn',
        'website' => 'https://7tcc.great-site.net',
        'address' => '273 An Dương Vương – Phường 3 – Quận 5',
        'hotline' => '0909888888',
        'email' => 'zaikaman123@gmail.com',
        'policies' => [
            'return' => 'Đổi trả trong vòng 30 ngày nếu sản phẩm còn nguyên tem mác',
            'shipping' => 'Miễn phí vận chuyển cho đơn hàng từ 500.000đ',
            'payment' => 'COD, chuyển khoản, Momo',
            'warranty' => 'Bảo hành sản phẩm 6 tháng với lỗi từ nhà sản xuất'
        ],
        'capabilities' => [
            'Tư vấn chi tiết về các sản phẩm trên (giá, số lượng, mô tả)',
            'Hướng dẫn cách chọn size',
            'Giải đáp thắc mắc về chính sách đổi trả, bảo hành',
            'Tư vấn phương thức thanh toán và vận chuyển',
            'Hỗ trợ các vấn đề về đơn hàng'
        ]
    ]
];

// In ra dưới dạng JSON
echo json_encode($response_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
