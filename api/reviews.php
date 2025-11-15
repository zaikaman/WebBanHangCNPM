<?php
session_start();
include('../admincp/config/config.php');

header('Content-Type: application/json');

// Hàm lấy rating trung bình và tổng số đánh giá của sản phẩm
function getProductRating($id_sp, $mysqli) {
    $sql = "SELECT 
            AVG(rating) as avg_rating,
            COUNT(*) as total_reviews,
            SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as star_5,
            SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as star_4,
            SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as star_3,
            SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as star_2,
            SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as star_1
            FROM tbl_danhgia_sp 
            WHERE id_sp = ? AND trang_thai = 1";
    
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_sp);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    return [
        'avg_rating' => $data['avg_rating'] ? round($data['avg_rating'], 1) : 0,
        'total_reviews' => $data['total_reviews'] ?? 0,
        'star_distribution' => [
            '5' => $data['star_5'] ?? 0,
            '4' => $data['star_4'] ?? 0,
            '3' => $data['star_3'] ?? 0,
            '2' => $data['star_2'] ?? 0,
            '1' => $data['star_1'] ?? 0
        ]
    ];
}

// Lấy danh sách đánh giá của sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_reviews') {
    $id_sp = isset($_GET['id_sp']) ? intval($_GET['id_sp']) : 0;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = 5; // Số đánh giá mỗi trang
    $offset = ($page - 1) * $limit;
    
    if ($id_sp <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
        exit;
    }
    
    // Lấy rating tổng quan
    $rating_data = getProductRating($id_sp, $mysqli);
    
    // Lấy danh sách đánh giá với phân trang
    $sql = "SELECT r.*, k.ten_khachhang, k.email 
            FROM tbl_danhgia_sp r 
            INNER JOIN tbl_dangky k ON r.id_dangky = k.id_dangky 
            WHERE r.id_sp = ? AND r.trang_thai = 1 
            ORDER BY r.ngay_tao DESC 
            LIMIT ? OFFSET ?";
    
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $id_sp, $limit, $offset);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $reviews = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = [
            'id' => $row['id'],
            'rating' => $row['rating'],
            'noi_dung' => $row['noi_dung'],
            'ngay_tao' => $row['ngay_tao'],
            'ten_khachhang' => $row['ten_khachhang']
        ];
    }
    
    // Đếm tổng số đánh giá để tính số trang
    $sql_count = "SELECT COUNT(*) as total FROM tbl_danhgia_sp WHERE id_sp = ? AND trang_thai = 1";
    $stmt_count = mysqli_prepare($mysqli, $sql_count);
    mysqli_stmt_bind_param($stmt_count, "i", $id_sp);
    mysqli_stmt_execute($stmt_count);
    $result_count = mysqli_stmt_get_result($stmt_count);
    $total_count = mysqli_fetch_assoc($result_count)['total'];
    
    echo json_encode([
        'success' => true,
        'data' => [
            'reviews' => $reviews,
            'rating_summary' => $rating_data,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => ceil($total_count / $limit),
                'total_reviews' => $total_count
            ]
        ]
    ]);
    exit;
}

// Lấy rating summary (dùng cho trang danh sách sản phẩm)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_rating') {
    $id_sp = isset($_GET['id_sp']) ? intval($_GET['id_sp']) : 0;
    
    if ($id_sp <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
        exit;
    }
    
    $rating_data = getProductRating($id_sp, $mysqli);
    
    echo json_encode([
        'success' => true,
        'data' => $rating_data
    ]);
    exit;
}

// Thêm đánh giá mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_review') {
    // Kiểm tra đăng nhập
    if (!isset($_SESSION['id_khachhang'])) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để đánh giá']);
        exit;
    }
    
    $id_sp = isset($_POST['id_sp']) ? intval($_POST['id_sp']) : 0;
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $noi_dung = isset($_POST['noi_dung']) ? trim($_POST['noi_dung']) : '';
    $id_dangky = $_SESSION['id_khachhang'];
    
    // Validate
    if ($id_sp <= 0) {
        echo json_encode(['success' => false, 'message' => 'Sản phẩm không hợp lệ']);
        exit;
    }
    
    if ($rating < 1 || $rating > 5) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng chọn số sao từ 1 đến 5']);
        exit;
    }
    
    // Kiểm tra xem khách hàng đã đánh giá sản phẩm này chưa (chỉ check đánh giá đã được duyệt)
    $sql_check = "SELECT id FROM tbl_danhgia_sp WHERE id_sp = ? AND id_dangky = ? AND trang_thai = 1";
    $stmt_check = mysqli_prepare($mysqli, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "ii", $id_sp, $id_dangky);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    
    $num_reviews = mysqli_num_rows($result_check);
    
    if ($num_reviews > 0) {
        echo json_encode(['success' => false, 'message' => 'Bạn đã đánh giá sản phẩm này rồi']);
        exit;
    }
    
    // Kiểm tra xem khách hàng đã mua sản phẩm này chưa (tùy chọn - có thể bỏ comment nếu muốn bắt buộc)
    // $sql_purchased = "SELECT ct.id FROM tbl_chitiet_gh ct 
    //                   INNER JOIN tbl_hoadon h ON ct.ma_gh = h.ma_gh 
    //                   WHERE ct.id_sp = ? AND h.id_khachhang = ? AND h.trang_thai = 1";
    // $stmt_purchased = mysqli_prepare($mysqli, $sql_purchased);
    // mysqli_stmt_bind_param($stmt_purchased, "ii", $id_sp, $id_dangky);
    // mysqli_stmt_execute($stmt_purchased);
    // $result_purchased = mysqli_stmt_get_result($stmt_purchased);
    
    // if (mysqli_num_rows($result_purchased) == 0) {
    //     echo json_encode(['success' => false, 'message' => 'Bạn chỉ có thể đánh giá sản phẩm đã mua']);
    //     exit;
    // }
    
    // Thêm đánh giá
    $sql_insert = "INSERT INTO tbl_danhgia_sp (id_sp, id_dangky, rating, noi_dung, ngay_tao, trang_thai) 
                   VALUES (?, ?, ?, ?, NOW(), 1)";
    $stmt_insert = mysqli_prepare($mysqli, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "iiis", $id_sp, $id_dangky, $rating, $noi_dung);
    
    if (mysqli_stmt_execute($stmt_insert)) {
        // Lấy rating mới sau khi thêm
        $rating_data = getProductRating($id_sp, $mysqli);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Cảm ơn bạn đã đánh giá sản phẩm!',
            'rating_summary' => $rating_data
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>
