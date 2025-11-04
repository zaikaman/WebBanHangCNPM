<?php
/**
 * Helper functions để xử lý khuyến mãi
 */

/**
 * Lấy thông tin khuyến mãi hiện tại của sản phẩm
 * 
 * @param int $id_sp ID sản phẩm
 * @param mysqli $mysqli Database connection
 * @return array|null Thông tin khuyến mãi hoặc null nếu không có
 */
function getActivePromotion($id_sp, $mysqli) {
    $sql = "SELECT km.* 
            FROM tbl_khuyenmai km
            INNER JOIN tbl_sanpham_khuyenmai spkm ON km.id_km = spkm.id_km
            WHERE spkm.id_sp = $id_sp 
            AND km.trang_thai = 1 
            AND NOW() BETWEEN km.ngay_bat_dau AND km.ngay_ket_thuc
            ORDER BY km.id_km DESC
            LIMIT 1";
    
    $result = mysqli_query($mysqli, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

/**
 * Tính giá sau khuyến mãi
 * 
 * @param float $gia_goc Giá gốc sản phẩm
 * @param array $km Thông tin khuyến mãi
 * @return float Giá sau khuyến mãi
 */
function calculatePromotionPrice($gia_goc, $km) {
    if (!$km) {
        return $gia_goc;
    }
    
    switch ($km['loai_km']) {
        case 'phan_tram':
            return $gia_goc * (1 - $km['gia_tri_km'] / 100);
        case 'tien_mat':
            return max(0, $gia_goc - $km['gia_tri_km']);
        case 'gia_moi':
            return $km['gia_tri_km'];
        default:
            return $gia_goc;
    }
}

/**
 * Tính phần trăm giảm giá
 * 
 * @param float $gia_goc Giá gốc
 * @param float $gia_km Giá khuyến mãi
 * @return int Phần trăm giảm (làm tròn)
 */
function calculateDiscountPercent($gia_goc, $gia_km) {
    if ($gia_goc <= 0) {
        return 0;
    }
    return round((($gia_goc - $gia_km) / $gia_goc) * 100);
}

/**
 * Hiển thị badge khuyến mãi
 * 
 * @param array $km Thông tin khuyến mãi
 * @return string HTML của badge
 */
function displayPromotionBadge($km) {
    if (!$km) {
        return '';
    }
    
    $text = '';
    switch ($km['loai_km']) {
        case 'phan_tram':
            $text = '-' . round($km['gia_tri_km']) . '%';
            break;
        case 'tien_mat':
            $text = '-' . number_format($km['gia_tri_km'], 0, ',', '.') . 'đ';
            break;
        case 'gia_moi':
            $text = 'SALE';
            break;
    }
    
    return '<span class="promotion-badge">' . $text . '</span>';
}

/**
 * Hiển thị giá sản phẩm với khuyến mãi (HTML)
 * 
 * @param float $gia_goc Giá gốc
 * @param array|null $km Thông tin khuyến mãi
 * @return string HTML hiển thị giá
 */
function displayProductPrice($gia_goc, $km = null) {
    $html = '<div class="product-price-wrapper">';
    
    if ($km) {
        $gia_km = calculatePromotionPrice($gia_goc, $km);
        $html .= '<span class="product-price-original">' . number_format($gia_goc, 0, ',', '.') . 'đ</span>';
        $html .= '<span class="product-price-sale">' . number_format($gia_km, 0, ',', '.') . 'đ</span>';
        
        // Badge giảm giá
        $percent = calculateDiscountPercent($gia_goc, $gia_km);
        if ($percent > 0) {
            $html .= '<span class="discount-percent">-' . $percent . '%</span>';
        }
    } else {
        $html .= '<span class="product-price">' . number_format($gia_goc, 0, ',', '.') . 'đ</span>';
    }
    
    $html .= '</div>';
    return $html;
}

/**
 * Lấy danh sách sản phẩm đang có khuyến mãi
 * 
 * @param mysqli $mysqli Database connection
 * @param int $limit Số lượng sản phẩm
 * @return mysqli_result Result set
 */
function getPromotionalProducts($mysqli, $limit = 10) {
    $sql = "SELECT DISTINCT sp.*, dm.name_sp as ten_dm,
            km.id_km, km.ten_km, km.loai_km, km.gia_tri_km
            FROM tbl_sanpham sp
            INNER JOIN tbl_danhmucqa dm ON sp.id_dm = dm.id_dm
            INNER JOIN tbl_sanpham_khuyenmai spkm ON sp.id_sp = spkm.id_sp
            INNER JOIN tbl_khuyenmai km ON spkm.id_km = km.id_km
            WHERE km.trang_thai = 1 
            AND NOW() BETWEEN km.ngay_bat_dau AND km.ngay_ket_thuc
            AND sp.tinh_trang = 1
            ORDER BY sp.id_sp DESC
            LIMIT $limit";
    
    return mysqli_query($mysqli, $sql);
}

/**
 * Kiểm tra sản phẩm có khuyến mãi không
 * 
 * @param int $id_sp ID sản phẩm
 * @param mysqli $mysqli Database connection
 * @return bool
 */
function hasPromotion($id_sp, $mysqli) {
    $km = getActivePromotion($id_sp, $mysqli);
    return $km !== null;
}

/**
 * Format thông tin khuyến mãi thành text
 * 
 * @param array $km Thông tin khuyến mãi
 * @return string
 */
function getPromotionText($km) {
    if (!$km) {
        return '';
    }
    
    switch ($km['loai_km']) {
        case 'phan_tram':
            return 'Giảm ' . round($km['gia_tri_km']) . '%';
        case 'tien_mat':
            return 'Giảm ' . number_format($km['gia_tri_km'], 0, ',', '.') . 'đ';
        case 'gia_moi':
            return 'Giá đặc biệt';
        default:
            return '';
    }
}

/**
 * Lấy thời gian còn lại của khuyến mãi
 * 
 * @param array $km Thông tin khuyến mãi
 * @return string Thời gian còn lại dạng text
 */
function getPromotionTimeRemaining($km) {
    if (!$km) {
        return '';
    }
    
    $end_time = strtotime($km['ngay_ket_thuc']);
    $now = time();
    $diff = $end_time - $now;
    
    if ($diff <= 0) {
        return 'Đã kết thúc';
    }
    
    $days = floor($diff / (60 * 60 * 24));
    $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
    
    if ($days > 0) {
        return 'Còn ' . $days . ' ngày';
    } elseif ($hours > 0) {
        return 'Còn ' . $hours . ' giờ';
    } else {
        return 'Sắp hết hạn';
    }
}
?>
