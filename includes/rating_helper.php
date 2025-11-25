<?php
/**
 * Helper functions for product ratings
 */

/**
 * Lấy rating trung bình và tổng số đánh giá của sản phẩm
 * @param int $id_sp ID sản phẩm
 * @param mysqli $mysqli Database connection
 * @return array ['avg_rating' => float, 'total_reviews' => int]
 */
function getProductRating($id_sp, $mysqli) {
    $sql = "SELECT 
            AVG(rating) as avg_rating,
            COUNT(*) as total_reviews
            FROM tbl_danhgia_sp 
            WHERE id_sp = ? AND trang_thai = 1";
    
    $stmt = mysqli_prepare($mysqli, $sql);
    if (!$stmt) {
        return ['avg_rating' => 0, 'total_reviews' => 0];
    }
    
    mysqli_stmt_bind_param($stmt, "i", $id_sp);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    return [
        'avg_rating' => $data['avg_rating'] ? round($data['avg_rating'], 1) : 0,
        'total_reviews' => $data['total_reviews'] ?? 0
    ];
}

/**
 * Tạo HTML hiển thị rating dạng ngôi sao
 * @param float $rating Điểm rating (0-5)
 * @param bool $showNumber Có hiển thị số điểm không
 * @param int $totalReviews Tổng số đánh giá
 * @return string HTML code
 */
function generateStarsHTML($rating, $showNumber = true, $totalReviews = 0) {
    $fullStars = floor($rating);
    $hasHalfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
    
    $html = '<div class="stars">';
    
    // Full stars
    for ($i = 0; $i < $fullStars; $i++) {
        $html .= '<i class="fas fa-star"></i>';
    }
    
    // Half star
    if ($hasHalfStar) {
        $html .= '<i class="fas fa-star-half-alt"></i>';
    }
    
    // Empty stars
    for ($i = 0; $i < $emptyStars; $i++) {
        $html .= '<i class="far fa-star"></i>';
    }
    
    $html .= '</div>';
    
    // Thêm số điểm nếu cần
    if ($showNumber && $rating > 0) {
        $reviewText = $totalReviews > 0 ? " ({$totalReviews})" : "";
        $html .= '<span class="rating-count">(' . number_format($rating, 1) . $reviewText . ')</span>';
    } else if ($showNumber && $totalReviews == 0) {
        $html .= '<span class="rating-count">(Chưa có đánh giá)</span>';
    }
    
    return $html;
}

/**
 * Lấy rating data cho nhiều sản phẩm cùng lúc (tối ưu performance)
 * @param array $product_ids Mảng các ID sản phẩm
 * @param mysqli $mysqli Database connection
 * @return array Mảng associate với key là id_sp và value là rating data
 */
function getBulkProductRatings($product_ids, $mysqli) {
    if (empty($product_ids)) {
        return [];
    }
    
    // Sanitize IDs
    $product_ids = array_map('intval', $product_ids);
    $ids_string = implode(',', $product_ids);
    
    $sql = "SELECT 
            id_sp,
            AVG(rating) as avg_rating,
            COUNT(*) as total_reviews
            FROM tbl_danhgia_sp 
            WHERE id_sp IN ($ids_string) AND trang_thai = 1
            GROUP BY id_sp";
    
    $result = mysqli_query($mysqli, $sql);
    
    $ratings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $ratings[$row['id_sp']] = [
            'avg_rating' => $row['avg_rating'] ? round($row['avg_rating'], 1) : 0,
            'total_reviews' => $row['total_reviews'] ?? 0
        ];
    }
    
    // Thêm default values cho sản phẩm chưa có đánh giá
    foreach ($product_ids as $id) {
        if (!isset($ratings[$id])) {
            $ratings[$id] = ['avg_rating' => 0, 'total_reviews' => 0];
        }
    }
    
    return $ratings;
}
?>
