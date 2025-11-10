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

// Lấy sản phẩm mới nhất
$sql_pro = "SELECT * FROM tbl_sanpham, tbl_danhmucqa 
            WHERE tbl_sanpham.id_dm = tbl_danhmucqa.id_dm 
            ORDER BY tbl_sanpham.id_sp DESC LIMIT $begin, 12";
$new_pro = mysqli_query($mysqli, $sql_pro);

// Lấy danh mục
$sql_categories = "SELECT * FROM tbl_danhmucqa ORDER BY id_dm DESC LIMIT 3";
$categories = mysqli_query($mysqli, $sql_categories);

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
         LATEST PRODUCTS SECTION
         ============================================ -->
    <section id="products" class="products-section">
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
                while ($row = mysqli_fetch_array($new_pro)) {
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
                                <?php } elseif ($row['so_luong'] > 0) { ?>
                                    <span class="product-badge">Mới</span>
                                <?php } else { ?>
                                    <span class="product-badge" style="background: #999;">Hết Hàng</span>
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
                                <p class="product-category"><?php echo $row['name_sp']; ?></p>
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

            <!-- Pagination -->
            <?php
            $sql_page = mysqli_query($mysqli, "SELECT * FROM tbl_sanpham");
            $row_count = mysqli_num_rows($sql_page);
            $trang = ceil($row_count / 12);
            
            if ($trang > 1) {
            ?>
                <div class="pagination-premium">
                    <?php
                    for ($i = 1; $i <= $trang; $i++) {
                        if ($i == $page || ($page == '' && $i == 1)) {
                            echo '<span class="active">' . $i . '</span>';
                        } else {
                            echo '<a href="index.php?trang=' . $i . '">' . $i . '</a>';
                        }
                    }
                    ?>
                </div>
            <?php
            }
            ?>
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
