<?php
// Lấy dữ liệu sản phẩm
if (isset($_GET['trang'])) {
    $page = $_GET['trang'];
} else {
    $page = '';
}
if ($page == '' || $page == 1) {
    $begin = 0;
} else {
    $begin = ($page * 12) - 12;
}

// Lấy sản phẩm nổi bật (bán chạy nhất) - giả sử có trường luot_ban hoặc dùng số lượng đã bán
// Nếu chưa có trường này, tạm thời dùng ngẫu nhiên
$sql_featured = "SELECT tbl_sanpham.*, tbl_danhmucqa.name_sp as ten_dm FROM tbl_sanpham, tbl_danhmucqa 
                 WHERE tbl_sanpham.id_dm = tbl_danhmucqa.id_dm 
                 AND tbl_sanpham.so_luong > 0
                 ORDER BY RAND() LIMIT 4";
$featured_pro = mysqli_query($mysqli, $sql_featured);
if (!$featured_pro) {
    error_log("Featured products query error: " . mysqli_error($mysqli));
}

// Lấy sản phẩm mới nhất  
$sql_newest = "SELECT tbl_sanpham.*, tbl_danhmucqa.name_sp as ten_dm FROM tbl_sanpham, tbl_danhmucqa 
               WHERE tbl_sanpham.id_dm = tbl_danhmucqa.id_dm 
               ORDER BY tbl_sanpham.id_sp DESC LIMIT 4";
$newest_pro = mysqli_query($mysqli, $sql_newest);
if (!$newest_pro) {
    error_log("Newest products query error: " . mysqli_error($mysqli));
}

// Lấy sản phẩm giảm giá nhiều nhất
$sql_discount = "SELECT sp.*, dm.name_sp as ten_dm, km.loai_km, km.gia_tri_km,
                 CASE 
                     WHEN km.loai_km = 'phan_tram' THEN km.gia_tri_km
                     WHEN km.loai_km = 'tien' THEN (km.gia_tri_km / sp.gia_sp * 100)
                     ELSE 0
                 END as discount_percent
                 FROM tbl_sanpham sp
                 INNER JOIN tbl_danhmucqa dm ON sp.id_dm = dm.id_dm
                 INNER JOIN tbl_sanpham_khuyenmai spkm ON sp.id_sp = spkm.id_sp
                 INNER JOIN tbl_khuyenmai km ON spkm.id_km = km.id_km
                 WHERE km.trang_thai = 1 
                 AND NOW() BETWEEN km.ngay_bat_dau AND km.ngay_ket_thuc
                 ORDER BY discount_percent DESC
                 LIMIT 4";
$discount_pro = mysqli_query($mysqli, $sql_discount);
if (!$discount_pro) {
    error_log("Discount products query error: " . mysqli_error($mysqli));
}

// Lấy danh mục
$sql_categories = "SELECT * FROM tbl_danhmucqa ORDER BY id_dm DESC LIMIT 3";
$categories = mysqli_query($mysqli, $sql_categories);
if (!$categories) {
    error_log("Categories query error: " . mysqli_error($mysqli));
}

// Đếm số lượng sản phẩm theo danh mục
function countProductsByCategory($mysqli, $category_id) {
    $sql_count = "SELECT COUNT(*) as total FROM tbl_sanpham WHERE id_dm = $category_id";
    $result = mysqli_query($mysqli, $sql_count);
    $row = mysqli_fetch_array($result);
    return $row['total'];
}
?>

<!-- Link CSS Premium -->
<link rel="stylesheet" href="css/homepage-premium.css?v=<?php echo time(); ?>">

<?php
// Debug: Check if queries executed successfully
if (!$featured_pro || !$newest_pro || !$categories) {
    echo '<div style="padding: 50px; text-align: center;">';
    echo '<h2>Có lỗi xảy ra khi tải dữ liệu</h2>';
    if (!$featured_pro) echo '<p>Lỗi query sản phẩm nổi bật</p>';
    if (!$newest_pro) echo '<p>Lỗi query sản phẩm mới nhất</p>';
    if (!$categories) echo '<p>Lỗi query danh mục</p>';
    echo '</div>';
    return;
}
?>

<div class="premium-homepage">
    
    <!-- ============================================
         HERO SECTION
         ============================================ -->
    <section class="premium-hero">
        <div class="hero-content">
            <div class="hero-text">
                <p class="hero-subtitle">Bộ Sưu Tập Mới Nhất</p>
                <h1 class="hero-title">PHONG CÁCH<br>THỂ THAO<br>ĐỈNH CAO</h1>
                <p class="hero-description">
                    Khám phá những thiết kế quần áo thể thao chất lượng cao, kết hợp hoàn hảo 
                    giữa phong cách và hiệu suất. Tạo nên phong cách riêng của bạn.
                </p>
                <div class="hero-cta">
                    <a href="index.php?#products" class="btn-hero-primary">Khám Phá Ngay</a>
                    <a href="#products" class="btn-hero-secondary">Xem Sản Phẩm</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         FEATURED CATEGORIES SECTION
         ============================================ -->
    <section class="featured-categories">
        <div class="container-premium">
            <div class="section-header">
                <p class="section-tag">Danh Mục Nổi Bật</p>
                <h2 class="section-title">Khám Phá Bộ Sưu Tập</h2>
                <p class="section-description">
                    Từ áo đấu chuyên nghiệp đến trang phục tập luyện, 
                    chúng tôi có mọi thứ bạn cần cho phong cách thể thao hoàn hảo
                </p>
            </div>

            <div class="categories-grid">
                <?php
                $category_images = [
                    'images/badminton.png',
                    'images/volleyball.png',
                    'images/soccer.png'
                ];
                $index = 0;
                while ($row_cat = mysqli_fetch_array($categories)) {
                    $product_count = countProductsByCategory($mysqli, $row_cat['id_dm']);
                ?>
                    <a href="index.php?quanly=danhmucsanpham&id=<?php echo $row_cat['id_dm']; ?>" 
                       class="category-card" style="text-decoration: none;">
                        <img src="<?php echo $category_images[$index % 3]; ?>" 
                             alt="<?php echo $row_cat['name_sp']; ?>" 
                             class="category-image">
                        <div class="category-content">
                            <h3 class="category-name"><?php echo $row_cat['name_sp']; ?></h3>
                            <p class="category-count"><?php echo $product_count; ?> Sản Phẩm</p>
                            <div class="category-link">
                                Xem Thêm <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                <?php
                    $index++;
                }
                ?>
            </div>
        </div>
    </section>

    <!-- ============================================
         FEATURED PRODUCTS SECTION (Nổi bật nhất - Bán chạy nhất)
         ============================================ -->
    <section id="products" class="products-section">
        <div class="container-premium">
            <div class="section-header">
                <p class="section-tag">Sản Phẩm Nổi Bật</p>
                <h2 class="section-title">Bán Chạy Nhất</h2>
                <p class="section-description">
                    Những sản phẩm được yêu thích nhất bởi khách hàng
                </p>
            </div>

            <div class="products-grid">
                <?php
                while ($row = mysqli_fetch_array($featured_pro)) {
                    // Kiểm tra khuyến mãi từ database
                    $promotion = getActivePromotion($row['id_sp'], $mysqli);
                    $gia_hien_thi = $row['gia_sp'];
                    $has_promotion = false;
                    
                    if ($promotion) {
                        $gia_hien_thi = calculatePromotionPrice($row['gia_sp'], $promotion);
                        $has_promotion = true;
                    }
                ?>
                    <div class="product-card-premium">
                        <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sp']; ?>" 
                           style="text-decoration: none; color: inherit;">
                            <div class="product-image-wrapper">
                                <?php 
                                // Ưu tiên hiển thị badge khuyến mãi nếu có
                                if ($has_promotion) { 
                                ?>
                                    <span class="product-badge">
                                        <?php 
                                        if ($promotion['loai_km'] == 'phan_tram') {
                                            echo '-' . round($promotion['gia_tri_km']) . '%';
                                        } else {
                                            echo 'SALE';
                                        }
                                        ?>
                                    </span>
                                <?php } else { ?>
                                    <span class="product-badge" style="background: #e67e22;">Hot</span>
                                <?php } ?>
                                
                                <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row['hinh_anh']; ?>" 
                                     alt="<?php echo $row['ten_sp']; ?>" 
                                     class="product-image-main">
                                
                                <div class="product-actions">
                                    <button class="product-action-btn" title="Yêu thích">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="product-action-btn" title="Xem nhanh">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="product-info">
                                <p class="product-category"><?php echo $row['ten_dm']; ?></p>
                                <h3 class="product-name"><?php echo $row['ten_sp']; ?></h3>
                                
                                <?php if ($has_promotion) { ?>
                                    <div class="product-price-wrapper">
                                        <span class="product-price">
                                            <?php echo number_format($gia_hien_thi, 0, ',', '.'); ?>đ
                                        </span>
                                        <span class="product-price-old">
                                            <?php echo number_format($row['gia_sp'], 0, ',', '.'); ?>đ
                                        </span>
                                    </div>
                                <?php } else { ?>
                                    <div class="product-price-wrapper">
                                        <span class="product-price">
                                            <?php echo number_format($row['gia_sp'], 0, ',', '.'); ?>đ
                                        </span>
                                    </div>
                                <?php } ?>
                                <div class="product-rating">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="rating-count">(4.5)</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="text-center mt-4">
                <a href="index.php?quanly=featured" class="btn-view-all">
                    Xem Tất Cả Sản Phẩm Nổi Bật <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================
         NEWEST PRODUCTS SECTION (Sản phẩm mới nhất)
         ============================================ -->
    <section class="products-section" style="background-color: #f8f9fa;">
        <div class="container-premium">
            <div class="section-header">
                <p class="section-tag">Sản Phẩm Mới</p>
                <h2 class="section-title">Bộ Sưu Tập Mới Nhất</h2>
                <p class="section-description">
                    Cập nhật những mẫu thiết kế mới nhất với chất liệu cao cấp 
                    và công nghệ tiên tiến
                </p>
            </div>

            <div class="products-grid">
                <?php
                while ($row = mysqli_fetch_array($newest_pro)) {
                    // Kiểm tra khuyến mãi từ database
                    $promotion = getActivePromotion($row['id_sp'], $mysqli);
                    $gia_hien_thi = $row['gia_sp'];
                    $has_promotion = false;
                    
                    if ($promotion) {
                        $gia_hien_thi = calculatePromotionPrice($row['gia_sp'], $promotion);
                        $has_promotion = true;
                    }
                ?>
                    <div class="product-card-premium">
                        <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sp']; ?>" 
                           style="text-decoration: none; color: inherit;">
                            <div class="product-image-wrapper">
                                <?php 
                                // Ưu tiên hiển thị badge khuyến mãi nếu có
                                if ($has_promotion) { 
                                ?>
                                    <span class="product-badge">
                                        <?php 
                                        if ($promotion['loai_km'] == 'phan_tram') {
                                            echo '-' . round($promotion['gia_tri_km']) . '%';
                                        } else {
                                            echo 'SALE';
                                        }
                                        ?>
                                    </span>
                                <?php } else { ?>
                                    <span class="product-badge">Mới</span>
                                <?php } ?>
                                
                                <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row['hinh_anh']; ?>" 
                                     alt="<?php echo $row['ten_sp']; ?>" 
                                     class="product-image-main">
                                
                                <div class="product-actions">
                                    <button class="product-action-btn" title="Yêu thích">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="product-action-btn" title="Xem nhanh">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="product-info">
                                <p class="product-category"><?php echo $row['ten_dm']; ?></p>
                                <h3 class="product-name"><?php echo $row['ten_sp']; ?></h3>
                                
                                <?php if ($has_promotion) { ?>
                                    <div class="product-price-wrapper">
                                        <span class="product-price">
                                            <?php echo number_format($gia_hien_thi, 0, ',', '.'); ?>đ
                                        </span>
                                        <span class="product-price-old">
                                            <?php echo number_format($row['gia_sp'], 0, ',', '.'); ?>đ
                                        </span>
                                    </div>
                                <?php } else { ?>
                                    <div class="product-price-wrapper">
                                        <span class="product-price">
                                            <?php echo number_format($row['gia_sp'], 0, ',', '.'); ?>đ
                                        </span>
                                    </div>
                                <?php } ?>
                                <div class="product-rating">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="rating-count">(4.5)</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="text-center mt-4">
                <a href="index.php?quanly=newest" class="btn-view-all">
                    Xem Tất Cả Sản Phẩm Mới <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================
         DISCOUNT PRODUCTS SECTION (Giảm giá nhiều nhất)
         ============================================ -->
    <section class="products-section">
        <div class="container-premium">
            <div class="section-header">
                <p class="section-tag">Khuyến Mãi Hot</p>
                <h2 class="section-title">Giảm Giá Nhiều Nhất</h2>
                <p class="section-description">
                    Những sản phẩm đang có chương trình giảm giá hấp dẫn
                </p>
            </div>

            <div class="products-grid">
                <?php
                $discount_count = mysqli_num_rows($discount_pro);
                if ($discount_count > 0) {
                    while ($row = mysqli_fetch_array($discount_pro)) {
                        // Tính giá sau khuyến mãi
                        if ($row['loai_km'] == 'phan_tram') {
                            $gia_hien_thi = $row['gia_sp'] * (1 - $row['gia_tri_km'] / 100);
                        } else {
                            $gia_hien_thi = $row['gia_sp'] - $row['gia_tri_km'];
                        }
                ?>
                    <div class="product-card-premium">
                        <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sp']; ?>" 
                           style="text-decoration: none; color: inherit;">
                            <div class="product-image-wrapper">
                                <span class="product-badge" style="background: #e74c3c;">
                                    -<?php echo round($row['discount_percent']); ?>%
                                </span>
                                
                                <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row['hinh_anh']; ?>" 
                                     alt="<?php echo $row['ten_sp']; ?>" 
                                     class="product-image-main">
                                
                                <div class="product-actions">
                                    <button class="product-action-btn" title="Yêu thích">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="product-action-btn" title="Xem nhanh">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="product-info">
                                <p class="product-category"><?php echo $row['ten_dm']; ?></p>
                                <h3 class="product-name"><?php echo $row['ten_sp']; ?></h3>
                                
                                <div class="product-price-wrapper">
                                    <span class="product-price">
                                        <?php echo number_format($gia_hien_thi, 0, ',', '.'); ?>đ
                                    </span>
                                    <span class="product-price-old">
                                        <?php echo number_format($row['gia_sp'], 0, ',', '.'); ?>đ
                                    </span>
                                </div>
                                <div class="product-rating">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="rating-count">(4.5)</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                    }
                } else {
                    echo '<p style="text-align: center; width: 100%; padding: 40px 0;">Hiện chưa có sản phẩm giảm giá.</p>';
                }
                ?>
            </div>

            <?php if ($discount_count > 0) { ?>
            <div class="text-center mt-4">
                <a href="index.php?quanly=discount" class="btn-view-all">
                    Xem Tất Cả Sản Phẩm Giảm Giá <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <?php } ?>
        </div>
    </section>

    <!-- ============================================
         BRAND STORY SECTION
         ============================================ -->
    <section class="brand-story">
        <div class="container-premium">
            <div class="brand-story-grid">
                <div class="brand-story-image">
                    <img src="images/together.png" alt="Câu chuyện thương hiệu">
                </div>
                <div class="brand-story-content">
                    <h2>Tạo Nên Phong Cách<br>Thể Thao Của Bạn</h2>
                    <p>
                        Chúng tôi tin rằng mỗi vận động viên đều xứng đáng có được trang phục 
                        tốt nhất để thể hiện phong cách và đạt được hiệu suất tối ưu.
                    </p>
                    <p>
                        Với hơn 10 năm kinh nghiệm trong ngành thời trang thể thao, 
                        chúng tôi cam kết mang đến những sản phẩm chất lượng cao nhất, 
                        kết hợp hoàn hảo giữa thiết kế hiện đại và tính năng vượt trội.
                    </p>

                    <div class="brand-features">
                        <div class="brand-feature">
                            <div class="brand-feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="brand-feature-content">
                                <h4>Chất Lượng Đảm Bảo</h4>
                                <p>100% sản phẩm chính hãng, bảo hành đầy đủ</p>
                            </div>
                        </div>

                        <div class="brand-feature">
                            <div class="brand-feature-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="brand-feature-content">
                                <h4>Giao Hàng Nhanh</h4>
                                <p>Miễn phí vận chuyển cho đơn hàng trên 500k</p>
                            </div>
                        </div>

                        <div class="brand-feature">
                            <div class="brand-feature-icon">
                                <i class="fas fa-undo-alt"></i>
                            </div>
                            <div class="brand-feature-content">
                                <h4>Đổi Trả Dễ Dàng</h4>
                                <p>Chính sách đổi trả trong vòng 30 ngày</p>
                            </div>
                        </div>

                        <div class="brand-feature">
                            <div class="brand-feature-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="brand-feature-content">
                                <h4>Hỗ Trợ 24/7</h4>
                                <p>Đội ngũ tư vấn nhiệt tình, chuyên nghiệp</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<style>
/* Override cho sidebar khi dùng trang premium */
.main_with_sidebar {
    display: block !important;
}

.main_content_with_sidebar {
    width: 100% !important;
    margin: 0 !important;
}

.sidebar {
    display: none !important;
}
</style>

<script>
// Scroll effects have been removed for better performance
</script>
