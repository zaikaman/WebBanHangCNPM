<?php
/**
 * File demo: Cách sử dụng helper khuyến mãi trong các trang hiển thị sản phẩm
 * 
 * Hướng dẫn tích hợp:
 * 1. Include file helper ở đầu file
 * 2. Lấy thông tin khuyến mãi khi load sản phẩm
 * 3. Sử dụng các function helper để hiển thị
 */

// ========================================
// BƯỚC 1: Include helper (thêm vào đầu file)
// ========================================
require_once('includes/promotion_helper.php');

// ========================================
// BƯỚC 2: Trong vòng lặp hiển thị sản phẩm
// ========================================

// Ví dụ: Trang danh mục sản phẩm (danhmuc-premium.php)
?>

<!-- Thêm CSS khuyến mãi vào <head> -->
<link rel="stylesheet" href="css/khuyenmai.css">

<?php
// Trong vòng lặp hiển thị sản phẩm
while ($row = mysqli_fetch_array($lietke)) {
    // Lấy thông tin khuyến mãi
    $promotion = getActivePromotion($row['id_sp'], $mysqli);
    $has_promotion = ($promotion !== null);
    
    // Tính giá sau khuyến mãi
    $gia_goc = $row['gia_sp'];
    $gia_hien_thi = $has_promotion ? calculatePromotionPrice($gia_goc, $promotion) : $gia_goc;
?>

<div class="product-card <?php echo $has_promotion ? 'has-promotion' : ''; ?>">
    <div class="product-image-wrapper">
        <!-- Badge khuyến mãi -->
        <?php if ($has_promotion): ?>
            <?php echo displayPromotionBadge($promotion); ?>
        <?php endif; ?>
        
        <img src="modules/quanLySanPham/uploads/<?php echo $row['hinh_anh']; ?>" alt="">
    </div>
    
    <div class="product-info">
        <h3><?php echo htmlspecialchars($row['ten_sp']); ?></h3>
        
        <!-- Hiển thị giá với khuyến mãi -->
        <?php if ($has_promotion): ?>
            <div class="product-price-wrapper">
                <span class="product-price-original">
                    <?php echo number_format($gia_goc, 0, ',', '.'); ?>đ
                </span>
                <span class="product-price-sale">
                    <?php echo number_format($gia_hien_thi, 0, ',', '.'); ?>đ
                </span>
                <?php 
                $discount_percent = calculateDiscountPercent($gia_goc, $gia_hien_thi);
                if ($discount_percent > 0): 
                ?>
                    <span class="discount-percent">-<?php echo $discount_percent; ?>%</span>
                <?php endif; ?>
            </div>
            
            <!-- Thông tin khuyến mãi -->
            <div class="promotion-timer">
                <i class="fas fa-clock"></i>
                <span><?php echo getPromotionTimeRemaining($promotion); ?></span>
            </div>
        <?php else: ?>
            <span class="product-price">
                <?php echo number_format($gia_goc, 0, ',', '.'); ?>đ
            </span>
        <?php endif; ?>
    </div>
</div>

<?php 
} // End while
?>

<!-- ========================================
     CÁCH 2: Sử dụng function helper tổng hợp
     ======================================== -->

<?php
while ($row = mysqli_fetch_array($lietke)) {
    $promotion = getActivePromotion($row['id_sp'], $mysqli);
?>

<div class="product-card">
    <div class="product-image-wrapper">
        <?php if ($promotion): ?>
            <?php echo displayPromotionBadge($promotion); ?>
        <?php endif; ?>
        
        <img src="modules/quanLySanPham/uploads/<?php echo $row['hinh_anh']; ?>" alt="">
    </div>
    
    <div class="product-info">
        <h3><?php echo htmlspecialchars($row['ten_sp']); ?></h3>
        
        <!-- Sử dụng function helper để hiển thị giá -->
        <?php echo displayProductPrice($row['gia_sp'], $promotion); ?>
        
        <?php if ($promotion): ?>
            <p class="promotion-name">
                <i class="fas fa-tag"></i> 
                <?php echo htmlspecialchars($promotion['ten_km']); ?>
            </p>
        <?php endif; ?>
    </div>
</div>

<?php 
}
?>

<!-- ========================================
     BƯỚC 3: Trang chi tiết sản phẩm
     ======================================== -->

<?php
// Lấy thông tin sản phẩm
$sql_chitiet = "SELECT * FROM tbl_sanpham WHERE id_sp = '$_GET[id]' LIMIT 1";
$query_chitiet = mysqli_query($mysqli, $sql_chitiet);
$row_chitiet = mysqli_fetch_array($query_chitiet);

// Lấy khuyến mãi
$promotion = getActivePromotion($row_chitiet['id_sp'], $mysqli);
$gia_goc = $row_chitiet['gia_sp'];
$gia_sau_km = $promotion ? calculatePromotionPrice($gia_goc, $promotion) : $gia_goc;
?>

<div class="product-detail">
    <div class="product-images">
        <?php if ($promotion): ?>
            <div class="hot-deal-banner">HOT DEAL</div>
            <?php echo displayPromotionBadge($promotion); ?>
        <?php endif; ?>
        <img src="modules/quanLySanPham/uploads/<?php echo $row_chitiet['hinh_anh']; ?>" alt="">
    </div>
    
    <div class="product-details">
        <h1><?php echo htmlspecialchars($row_chitiet['ten_sp']); ?></h1>
        
        <!-- Hiển thị giá -->
        <div class="price-section">
            <?php if ($promotion): ?>
                <div class="price-with-promotion">
                    <span class="original-price">
                        <?php echo number_format($gia_goc, 0, ',', '.'); ?>đ
                    </span>
                    <span class="sale-price">
                        <?php echo number_format($gia_sau_km, 0, ',', '.'); ?>đ
                    </span>
                    <span class="save-amount">
                        Tiết kiệm: <?php echo number_format($gia_goc - $gia_sau_km, 0, ',', '.'); ?>đ
                    </span>
                </div>
                
                <!-- Box thông tin khuyến mãi -->
                <div class="promotion-info">
                    <h4>
                        <i class="fas fa-gift"></i> 
                        <?php echo htmlspecialchars($promotion['ten_km']); ?>
                    </h4>
                    <p><?php echo htmlspecialchars($promotion['mo_ta']); ?></p>
                    <p>
                        <i class="fas fa-calendar-alt"></i>
                        Từ <?php echo date('d/m/Y', strtotime($promotion['ngay_bat_dau'])); ?>
                        đến <?php echo date('d/m/Y', strtotime($promotion['ngay_ket_thuc'])); ?>
                    </p>
                    <p class="time-remaining">
                        <i class="fas fa-clock"></i>
                        <strong><?php echo getPromotionTimeRemaining($promotion); ?></strong>
                    </p>
                </div>
            <?php else: ?>
                <span class="regular-price">
                    <?php echo number_format($gia_goc, 0, ',', '.'); ?>đ
                </span>
            <?php endif; ?>
        </div>
        
        <button class="btn-add-to-cart" data-id="<?php echo $row_chitiet['id_sp']; ?>">
            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
        </button>
    </div>
</div>

<!-- ========================================
     BƯỚC 4: Hiển thị danh sách sản phẩm khuyến mãi
     ======================================== -->

<section class="promotional-products">
    <h2>Sản phẩm đang giảm giá</h2>
    
    <div class="product-grid">
        <?php
        $promotional_products = getPromotionalProducts($mysqli, 8);
        
        while ($product = mysqli_fetch_array($promotional_products)) {
            $gia_goc = $product['gia_sp'];
            $gia_km = calculatePromotionPrice($gia_goc, $product);
            $discount = calculateDiscountPercent($gia_goc, $gia_km);
        ?>
        
        <div class="product-item has-promotion">
            <div class="promotion-badge">-<?php echo $discount; ?>%</div>
            
            <img src="modules/quanLySanPham/uploads/<?php echo $product['hinh_anh']; ?>" alt="">
            
            <h3><?php echo htmlspecialchars($product['ten_sp']); ?></h3>
            
            <div class="product-price-wrapper">
                <span class="product-price-original">
                    <?php echo number_format($gia_goc, 0, ',', '.'); ?>đ
                </span>
                <span class="product-price-sale">
                    <?php echo number_format($gia_km, 0, ',', '.'); ?>đ
                </span>
            </div>
            
            <a href="?quanly=sanpham&id=<?php echo $product['id_sp']; ?>" class="btn-view">
                Xem chi tiết
            </a>
        </div>
        
        <?php } ?>
    </div>
</section>

<!-- ========================================
     BƯỚC 5: Xử lý trong giỏ hàng
     ======================================== -->

<?php
// Khi thêm vào giỏ hàng, lưu giá sau khuyến mãi
if (isset($_POST['themgiohang'])) {
    $id_sp = $_POST['id_sp'];
    $so_luong = $_POST['so_luong'];
    
    // Lấy thông tin sản phẩm
    $sql = "SELECT * FROM tbl_sanpham WHERE id_sp = '$id_sp' LIMIT 1";
    $query = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_array($query);
    
    // Lấy khuyến mãi
    $promotion = getActivePromotion($id_sp, $mysqli);
    $gia_hien_tai = $promotion ? calculatePromotionPrice($row['gia_sp'], $promotion) : $row['gia_sp'];
    
    // Thêm vào giỏ hàng với giá đã tính khuyến mãi
    $_SESSION['cart'][$id_sp] = array(
        'ten_sp' => $row['ten_sp'],
        'gia_sp' => $gia_hien_tai, // Giá sau khuyến mãi
        'gia_goc' => $row['gia_sp'], // Giữ lại giá gốc để hiển thị
        'hinh_anh' => $row['hinh_anh'],
        'so_luong' => $so_luong,
        'ma_sp' => $row['ma_sp'],
        'id_km' => $promotion ? $promotion['id_km'] : null, // Lưu ID khuyến mãi
        'ten_km' => $promotion ? $promotion['ten_km'] : null
    );
}

// Hiển thị trong giỏ hàng
foreach ($_SESSION['cart'] as $key => $value) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($value['ten_sp']) . '</td>';
    
    // Hiển thị giá
    if (isset($value['gia_goc']) && $value['gia_goc'] != $value['gia_sp']) {
        echo '<td>';
        echo '<span style="text-decoration: line-through; color: #999;">';
        echo number_format($value['gia_goc'], 0, ',', '.') . 'đ';
        echo '</span><br>';
        echo '<span style="color: #ff4444; font-weight: bold;">';
        echo number_format($value['gia_sp'], 0, ',', '.') . 'đ';
        echo '</span>';
        if (isset($value['ten_km'])) {
            echo '<br><small class="text-success">(' . htmlspecialchars($value['ten_km']) . ')</small>';
        }
        echo '</td>';
    } else {
        echo '<td>' . number_format($value['gia_sp'], 0, ',', '.') . 'đ</td>';
    }
    
    echo '<td>' . $value['so_luong'] . '</td>';
    echo '<td>' . number_format($value['gia_sp'] * $value['so_luong'], 0, ',', '.') . 'đ</td>';
    echo '</tr>';
}
?>
