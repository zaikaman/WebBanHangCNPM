<link rel="stylesheet" type="text/css" href="css/sanpham.css?v=<?php echo time(); ?>">
<link rel="stylesheet" type="text/css" href="css/reviews.css?v=<?php echo time(); ?>">
<?php
// Get main product info
$sql_pro_info = "SELECT * FROM tbl_sanpham WHERE tbl_sanpham.id_sp = '$_GET[id]' LIMIT 1";
$pro_info_query = mysqli_query($mysqli, $sql_pro_info);
$info = mysqli_fetch_array($pro_info_query);

// Get sizes and quantities for the product from the new table
$sql_sizes = "SELECT size, so_luong FROM tbl_sanpham_sizes WHERE id_sp = '$_GET[id]' ORDER BY FIELD(size, 'S', 'M', 'L', 'XL')";
$sizes_query = mysqli_query($mysqli, $sql_sizes);

$allowed_sizes = ['S', 'M', 'L', 'XL']; // Chỉ hiển thị các size này
$available_sizes = [];
$size_quantities = [];
if ($sizes_query) {
    while ($row = mysqli_fetch_assoc($sizes_query)) {
        $sz = isset($row['size']) ? $row['size'] : '';
        // Bỏ qua các size không nằm trong danh sách cho phép (ví dụ: XXL)
        if (!in_array($sz, $allowed_sizes, true)) {
            continue;
        }
        // Map số lượng chỉ cho các size được phép
        $size_quantities[$sz] = $row['so_luong'];
        // Chỉ thêm vào dropdown nếu còn hàng
        if ($row['so_luong'] > 0) {
            $available_sizes[] = $row;
        }
    }
}
$is_in_stock = !empty($available_sizes);
?>
<div class="main_content">
    <form class="product_content" method="POST" action="/WebBanHangCNPM/pages/main/themgiohang.php?idsanpham=<?php echo $info['id_sp'] ?>">
        <div id="product-data" data-sizes='<?php echo json_encode($size_quantities); ?>' class="d-none"></div>
        
        <!-- Product Image Gallery -->
        <div class="product_img_gallery">
            <?php
            // Lấy tất cả ảnh của sản phẩm
            $product_images = [];
            if (!empty($info['hinh_anh'])) {
                $product_images[] = $info['hinh_anh'];
            }
            if (!empty($info['hinh_anh_2'])) {
                $product_images[] = $info['hinh_anh_2'];
            }
            if (!empty($info['hinh_anh_3'])) {
                $product_images[] = $info['hinh_anh_3'];
            }
            
            // Nếu không có ảnh nào, dùng ảnh mặc định
            if (empty($product_images)) {
                $product_images[] = 'no-image.jpg';
            }
            ?>
            
            <!-- Main Image Display -->
            <div class="main_image_container">
                <div class="main_image_wrapper">
                    <?php foreach ($product_images as $index => $image): ?>
                        <img 
                            class="main_product_image <?php echo $index === 0 ? 'active' : ''; ?>" 
                            src="admincp/modules/quanLySanPham/uploads/<?php echo $image; ?>" 
                            alt="<?php echo $info['ten_sp']; ?> - Ảnh <?php echo $index + 1; ?>"
                            data-index="<?php echo $index; ?>"
                        >
                    <?php endforeach; ?>
                </div>
                
                <!-- Navigation Arrows (chỉ hiển thị nếu có > 1 ảnh) -->
                <?php if (count($product_images) > 1): ?>
                    <button type="button" class="gallery_nav prev" onclick="changeMainImage(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" class="gallery_nav next" onclick="changeMainImage(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    
                    <!-- Image Counter -->
                    <div class="image_counter">
                        <span class="current_image">1</span> / <span class="total_images"><?php echo count($product_images); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Thumbnail Gallery (chỉ hiển thị nếu có > 1 ảnh) -->
            <?php if (count($product_images) > 1): ?>
                <div class="thumbnail_gallery">
                    <?php foreach ($product_images as $index => $image): ?>
                        <div 
                            class="thumbnail_item <?php echo $index === 0 ? 'active' : ''; ?>" 
                            onclick="selectImage(<?php echo $index; ?>)"
                            data-index="<?php echo $index; ?>"
                        >
                            <img 
                                src="admincp/modules/quanLySanPham/uploads/<?php echo $image; ?>" 
                                alt="Thumbnail <?php echo $index + 1; ?>"
                            >
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="product_detail">
            <div>
                <p class="ten_sp"><?php echo $info['ten_sp'] ?></p>
                <p class="quantity">Tình trạng : 
                    <span class="text-highlight-red">
                        <?php echo $is_in_stock ? 'Còn hàng' : 'Hết hàng'; ?>
                    </span>
                </p>
                <?php
                // Kiểm tra và hiển thị giá khuyến mãi
                $promotion = getActivePromotion($info['id_sp'], $mysqli);
                if ($promotion) {
                    $gia_km = calculatePromotionPrice($info['gia_sp'], $promotion);
                    ?>
                    <div class="product-price-section">
                        <p class="gia_sp_goc" style="text-decoration: line-through; color: #999; font-size: 0.9em;">
                            <?php echo number_format($info['gia_sp'], 0, ',', '.') . 'đ' ?>
                        </p>
                        <p class="gia_sp" style="color: #e74c3c; font-weight: bold; font-size: 1.2em;">
                            <?php echo number_format($gia_km, 0, ',', '.') . 'đ' ?>
                        </p>
                        <span class="promotion-badge" style="background: #e74c3c; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.85em;">
                            -<?php echo calculateDiscountPercent($info['gia_sp'], $gia_km); ?>%
                        </span>
                    </div>
                    <?php
                } else {
                    ?>
                    <p class="gia_sp"><?php echo number_format($info['gia_sp'], 0, ',', '.') . 'đ' ?></p>
                    <?php
                }
                ?>
                <?php
                $id_dm = isset($info['id_dm']) ? intval($info['id_dm']) : 0;
                $category_name = 'Không rõ';
                if ($id_dm > 0) {
                    $sql_cat = "SELECT name_sp FROM tbl_danhmucqa WHERE id_dm = '" . $id_dm . "' LIMIT 1";
                    $res_cat = mysqli_query($mysqli, $sql_cat);
                    if ($res_cat && mysqli_num_rows($res_cat) > 0) {
                        $row_cat = mysqli_fetch_assoc($res_cat);
                        if (!empty($row_cat['name_sp'])) {
                            $category_name = htmlspecialchars($row_cat['name_sp'], ENT_QUOTES, 'UTF-8');
                        }
                    }
                }
                ?>
                <?php if ($id_dm > 0): ?>
                    <p>Danh mục : <strong>
                        <a class="category-link" href="index.php?quanly=danhmucsanpham&id=<?php echo intval($id_dm); ?>">
                            <?php echo $category_name; ?>
                        </a>
                    </strong></p>
                <?php else: ?>
                    <p>Danh mục : <strong><?php echo $category_name; ?></strong></p>
                <?php endif; ?>
            </div>

            <?php if($is_in_stock):
            ?>
                <div class="size_selection">
                    <?php
                    $size_guidelines = [
                        'S'  => '42 - 47kg',
                        'M'  => '50 - 60kg',
                        'L'  => 'Trên 60kg',
                        'XL' => 'Trên 70kg'
                    ];
                    $present_sizes = array_keys($size_quantities);
                    ?>
                    <label for="size_select" class="product-form-label">Kích cỡ :</label>
                    <select name="size" id="size_select" class="size_select product-form-select">
                        <?php foreach ($available_sizes as $size_data): 
                            $sz = htmlspecialchars($size_data['size'], ENT_QUOTES, 'UTF-8');
                        ?>
                            <option value="<?php echo $sz; ?>">
                                <?php
                                echo $sz;
                                if (isset($size_guidelines[$size_data['size']])) {
                                    echo ' - ' . $size_guidelines[$size_data['size']];
                                }
                                ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="soluong">
                    <label for="soluong_input" class="product-form-label mt-10">Số lượng :</label>
                    <div class="d-block">
                        <button type="button" id="giam" class="soluong_btn">-</button>
                        <input class="soluong_input" id="soluong_input" name="so_luong" type="number" value="1" min="1">
                        <button type="button" id="tang" class="soluong_btn">+</button>
                    </div>
                </div>
            <?php endif;
            ?>

            <div class="tabs">
                <ul id="tabs-nav">
                    <li><a href="#mota">Mô tả</a></li>
                    <li><a href="#danhgia">Đánh giá</a></li>
                </ul>
                <div id="tabs-content">
                    <div id="mota" class="tab-content"><?php echo nl2br(str_replace(['
', '
'], "\n", $info['tom_tat'])) ?></div>
                    <div id="danhgia" class="tab-content">
                        <!-- Product Reviews Section -->
                        <div class="product-reviews-wrapper">
                            <!-- Rating Summary -->
                            <div class="rating-summary" id="rating-summary">
                                <div class="rating-overview">
                                    <div class="average-rating">
                                        <span class="rating-number" id="avg-rating">0</span>
                                        <div class="stars-display" id="stars-display">
                                            <span class="star-icon">★</span>
                                            <span class="star-icon">★</span>
                                            <span class="star-icon">★</span>
                                            <span class="star-icon">★</span>
                                            <span class="star-icon">★</span>
                                        </div>
                                        <p class="total-reviews" id="total-reviews">0 đánh giá</p>
                                    </div>
                                    
                                    <div class="rating-bars">
                                        <div class="rating-bar-item">
                                            <span class="star-label">5 <span class="star-icon">★</span></span>
                                            <div class="progress-bar">
                                                <div class="progress-fill" id="bar-5" style="width: 0%"></div>
                                            </div>
                                            <span class="count" id="count-5">0</span>
                                        </div>
                                        <div class="rating-bar-item">
                                            <span class="star-label">4 <span class="star-icon">★</span></span>
                                            <div class="progress-bar">
                                                <div class="progress-fill" id="bar-4" style="width: 0%"></div>
                                            </div>
                                            <span class="count" id="count-4">0</span>
                                        </div>
                                        <div class="rating-bar-item">
                                            <span class="star-label">3 <span class="star-icon">★</span></span>
                                            <div class="progress-bar">
                                                <div class="progress-fill" id="bar-3" style="width: 0%"></div>
                                            </div>
                                            <span class="count" id="count-3">0</span>
                                        </div>
                                        <div class="rating-bar-item">
                                            <span class="star-label">2 <span class="star-icon">★</span></span>
                                            <div class="progress-bar">
                                                <div class="progress-fill" id="bar-2" style="width: 0%"></div>
                                            </div>
                                            <span class="count" id="count-2">0</span>
                                        </div>
                                        <div class="rating-bar-item">
                                            <span class="star-label">1 <span class="star-icon">★</span></span>
                                            <div class="progress-bar">
                                                <div class="progress-fill" id="bar-1" style="width: 0%"></div>
                                            </div>
                                            <span class="count" id="count-1">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Review Form -->
                            <?php if (isset($_SESSION['id_khachhang']) && isset($_SESSION['dang_ky'])): ?>
                            <div class="review-form-section">
                                <h4>Viết Đánh Giá Của Bạn</h4>
                                <form id="review-form" class="review-form" onsubmit="return false;">
                                    <input type="hidden" name="id_sp" value="<?php echo $info['id_sp']; ?>">
                                    
                                    <div class="form-group">
                                        <label>Đánh giá của bạn:</label>
                                        <div class="star-rating" id="star-rating">
                                            <span class="star-icon" data-rating="1">☆</span>
                                            <span class="star-icon" data-rating="2">☆</span>
                                            <span class="star-icon" data-rating="3">☆</span>
                                            <span class="star-icon" data-rating="4">☆</span>
                                            <span class="star-icon" data-rating="5">☆</span>
                                        </div>
                                        <input type="hidden" name="rating" id="rating-value" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="review-content">Nhận xét của bạn:</label>
                                        <textarea name="noi_dung" id="review-content" rows="4" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..."></textarea>
                                    </div>
                                    
                                    <button type="button" class="submit-review-btn" id="submit-review-btn">Gửi Đánh Giá</button>
                                </form>
                                <div id="review-message" class="review-message"></div>
                            </div>
                            <?php else: ?>
                            <div class="login-to-review">
                                <p>Vui lòng <a href="index.php?quanly=dangnhap">đăng nhập</a> để đánh giá sản phẩm</p>
                            </div>
                            <?php endif; ?>

                            <!-- Reviews List -->
                            <div class="reviews-list" id="reviews-list">
                                <!-- Reviews will be loaded here by JavaScript -->
                            </div>
                            
                            <!-- Pagination -->
                            <div class="reviews-pagination" id="reviews-pagination">
                                <!-- Pagination will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php 
            // Hiển thị thông báo lỗi nếu có
            if (isset($_GET['error']) && $_GET['error'] == 'quantity_exceeded') {
                $remaining_qty = isset($_GET['remaining']) ? (int)$_GET['remaining'] : 0;
                $error_message = "Số lượng bạn yêu cầu vượt quá số lượng còn lại trong kho.";
                if ($remaining_qty > 0) {
                    $error_message .= " Chỉ có thể thêm tối đa <strong>" . $remaining_qty . "</strong> sản phẩm nữa.";
                } else {
                    $error_message = "Bạn đã có tất cả sản phẩm với size này trong giỏ hàng. Không thể thêm nữa.";
                }
                echo '<div class="alert alert-danger">' . $error_message . '</div>';
            }
            // Hiển thị thông báo thành công nếu có
            if (isset($_GET['additem_success']) && $_GET['additem_success'] == 1) {
                 echo '<div class="alert alert-success">Đã thêm sản phẩm vào giỏ hàng thành công!</div>';
            }
            ?>

            <?php if ($is_in_stock):
            ?>
                <?php if (isset($_SESSION['id_khachhang']) && isset($_SESSION['dang_ky'])):
                ?>
                    <div class="action-button-container">
                        <input class="mua_btn" type="submit" name="themgiohang" value="Thêm vào giỏ hàng">
                    </div>
                <?php else:
                ?>
                    <div class="action-button-container">
                        <a class="mua_btn" href="index.php?quanly=dangnhap">Đăng nhập để mua hàng</a>
                    </div>
                <?php endif;
                ?>
            <?php endif;
            ?>
        </div>
    </form>
</div>

<!-- Related Products -->
<div class="related-products">
    <div class="related-products-container">
        <h3 class="related-products-title">Sản phẩm liên quan</h3>
        <ul class="related-product-list">
            <?php
            $id_dm = (int)$info['id_dm'];
            $current_id = (int)$_GET['id'];

            // Lấy sản phẩm cùng danh mục, sắp xếp theo số lượng đã bán (nếu có), fallback về RAND() nếu chưa có dữ liệu bán
            $sql_related = "SELECT p.*, IFNULL(SUM(ct.so_luong_mua),0) AS sold_qty
                            FROM tbl_sanpham p
                            LEFT JOIN tbl_chitiet_gh ct ON ct.id_sp = p.id_sp
                            LEFT JOIN tbl_hoadon h ON h.ma_gh = ct.ma_gh AND h.trang_thai = 1
                            WHERE p.id_dm = '$id_dm' AND p.id_sp != '$current_id'
                            GROUP BY p.id_sp
                            ORDER BY sold_qty DESC
                            LIMIT 5";
            $query_related = mysqli_query($mysqli, $sql_related);

            // Nếu không có dữ liệu bán hoặc truy vấn trả về < 1 hàng, dùng fallback lấy ngẫu nhiên
            if (!$query_related || mysqli_num_rows($query_related) < 1) {
                $sql_related = "SELECT * FROM tbl_sanpham WHERE id_dm = '$id_dm' AND id_sp != '$current_id' ORDER BY RAND() LIMIT 5";
                $query_related = mysqli_query($mysqli, $sql_related);
            }
            while ($row_related = mysqli_fetch_array($query_related)) {
                // Kiểm tra khuyến mãi cho sản phẩm liên quan
                $promotion_related = getActivePromotion($row_related['id_sp'], $mysqli);
                $gia_hien_thi_related = $row_related['gia_sp'];
                $has_promotion_related = false;
                
                if ($promotion_related) {
                    $gia_hien_thi_related = calculatePromotionPrice($row_related['gia_sp'], $promotion_related);
                    $has_promotion_related = true;
                }
            ?>
                <li>
                    <a href="index.php?quanly=sanpham&id=<?php echo $row_related['id_sp'] ?>">
                        <div class="product-image-container">
                            <?php if ($has_promotion_related) { ?>
                                <span class="badge bg-danger position-absolute" style="top: 5px; right: 5px; z-index: 10; font-size: 0.75em;">
                                    <?php 
                                    if ($promotion_related['loai_km'] == 'phan_tram') {
                                        echo '-' . round($promotion_related['gia_tri_km']) . '%';
                                    } else {
                                        echo 'SALE';
                                    }
                                    ?>
                                </span>
                            <?php } ?>
                            <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row_related['hinh_anh'] ?>" alt="<?php echo $row_related['ten_sp'] ?>">
                        </div>
                        <div class="product-info">
                            <p class="title_product"><?php echo $row_related['ten_sp'] ?></p>
                            <?php if ($has_promotion_related) { ?>
                                <p class="price_product">
                                    <span class="text-muted text-decoration-line-through" style="font-size: 0.85em;">
                                        <?php echo number_format($row_related['gia_sp'], 0, ',', '.') . 'đ' ?>
                                    </span>
                                    <br>
                                    <span class="text-danger fw-bold">
                                        <?php echo number_format($gia_hien_thi_related, 0, ',', '.') . 'đ' ?>
                                    </span>
                                </p>
                            <?php } else { ?>
                                <p class="price_product"><?php echo number_format($row_related['gia_sp'],0,',','.').'đ'?></p>
                            <?php } ?>
                        </div>
                    </a>
                    <a href="index.php?quanly=sanpham&id=<?php echo $row_related['id_sp'] ?>" class="view-details-btn">Xem chi tiết</a>
                </li>
            <?php
            }
            ?>
        </ul>

        <?php if (isset($id_dm) && (int)$id_dm > 0): ?>
            <div class="related-more" style="text-align:center; margin-top:18px;">
                <a href="index.php?quanly=danhmucsanpham&id=<?php echo (int)$id_dm; ?>" 
                   class="related-more-btn" 
                   style="display:inline-block;padding:10px 18px;background:#d33;color:#fff;border-radius:6px;text-decoration:none;">
                   Xem thêm trong danh mục
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="js/sanpham.js" defer></script>
<script src="js/reviews.js" defer></script>
<script>
// Pass product ID to reviews.js
window.productId = <?php echo $info['id_sp']; ?>;

// ===================================
// PRODUCT IMAGE GALLERY SLIDER
// ===================================
let currentImageIndex = 0;
const images = document.querySelectorAll('.main_product_image');
const thumbnails = document.querySelectorAll('.thumbnail_item');
const totalImages = images.length;

// Change main image function
function changeMainImage(direction) {
    if (totalImages <= 1) return;
    
    // Remove active class from current image
    images[currentImageIndex].classList.remove('active');
    thumbnails[currentImageIndex].classList.remove('active');
    
    // Calculate new index
    currentImageIndex += direction;
    
    // Loop around
    if (currentImageIndex >= totalImages) {
        currentImageIndex = 0;
    } else if (currentImageIndex < 0) {
        currentImageIndex = totalImages - 1;
    }
    
    // Add active class to new image
    images[currentImageIndex].classList.add('active');
    thumbnails[currentImageIndex].classList.add('active');
    
    // Update counter
    updateImageCounter();
}

// Select specific image
function selectImage(index) {
    if (index === currentImageIndex || index >= totalImages) return;
    
    // Remove active class from current
    images[currentImageIndex].classList.remove('active');
    thumbnails[currentImageIndex].classList.remove('active');
    
    // Set new index
    currentImageIndex = index;
    
    // Add active class to new
    images[currentImageIndex].classList.add('active');
    thumbnails[currentImageIndex].classList.add('active');
    
    // Update counter
    updateImageCounter();
}

// Update image counter
function updateImageCounter() {
    const counterElement = document.querySelector('.current_image');
    if (counterElement) {
        counterElement.textContent = currentImageIndex + 1;
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (totalImages <= 1) return;
    
    if (e.key === 'ArrowLeft') {
        changeMainImage(-1);
    } else if (e.key === 'ArrowRight') {
        changeMainImage(1);
    }
});

// Touch/Swipe support for mobile
let touchStartX = 0;
let touchEndX = 0;

const mainImageContainer = document.querySelector('.main_image_container');
if (mainImageContainer && totalImages > 1) {
    mainImageContainer.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, false);
    
    mainImageContainer.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);
}

function handleSwipe() {
    const swipeThreshold = 50; // Minimum distance for swipe
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            // Swipe left - next image
            changeMainImage(1);
        } else {
            // Swipe right - previous image
            changeMainImage(-1);
        }
    }
}

// Auto-play (optional - uncomment if needed)
/*
let autoPlayInterval;
function startAutoPlay() {
    if (totalImages > 1) {
        autoPlayInterval = setInterval(() => {
            changeMainImage(1);
        }, 5000); // Change every 5 seconds
    }
}

function stopAutoPlay() {
    if (autoPlayInterval) {
        clearInterval(autoPlayInterval);
    }
}

// Start autoplay when page loads
startAutoPlay();

// Pause on hover
if (mainImageContainer) {
    mainImageContainer.addEventListener('mouseenter', stopAutoPlay);
    mainImageContainer.addEventListener('mouseleave', startAutoPlay);
}
*/

// Initialize counter on page load
updateImageCounter();
</script>
