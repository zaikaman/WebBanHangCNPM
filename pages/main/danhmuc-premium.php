<?php
// PREMIUM CATEGORY PAGE - Version 2.0
// Kiểm tra và lấy tham số id từ URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Nếu không có id, hiển thị tất cả danh mục để người dùng chọn
    $sql_all_categories = "SELECT * FROM tbl_danhmucqa ORDER BY name_sp ASC";
    $query_all_categories = mysqli_query($mysqli, $sql_all_categories);
    
    if (mysqli_num_rows($query_all_categories) > 0) {
        ?>
        
        <!-- Category Selection Hero -->
        <div class="category-hero">
            <div class="category-hero-content">
                <h1 class="category-hero-title">TẤT CẢ DANH MỤC</h1>
                <p class="category-hero-description">
                    Khám phá bộ sưu tập đa dạng với hàng ngàn sản phẩm chất lượng cao
                </p>
            </div>
        </div>
        
        <div class="container-premium" style="padding-bottom: 100px;">
            <div class="products-grid-premium">
                <?php while ($category = mysqli_fetch_array($query_all_categories)): 
                    // Đếm số sản phẩm trong danh mục
                    $cat_id = $category['id_dm'];
                    $sql_count_products = "SELECT COUNT(*) as total FROM tbl_sanpham WHERE id_dm = '$cat_id'";
                    $query_count_products = mysqli_query($mysqli, $sql_count_products);
                    $count_result = mysqli_fetch_array($query_count_products);
                    $product_count = $count_result['total'];
                ?>
                    <a href="index.php?quanly=danhmucsanpham&id=<?php echo $category['id_dm']; ?>" 
                       class="product-card-premium" style="text-decoration: none;">
                        <div class="product-image-wrapper">
                            <img loading="lazy" 
                                 src="admincp/modules/quanLyDanhMucSanPham/uploads/<?php echo $category['hinh_anh']; ?>" 
                                 alt="<?php echo htmlspecialchars($category['name_sp']); ?>"
                                 class="product-image-main">
                            <span class="product-badge"><?php echo $product_count; ?> sản phẩm</span>
                        </div>
                        <div class="product-info">
                            <div class="product-category">DANH MỤC</div>
                            <h3 class="product-name"><?php echo htmlspecialchars($category['name_sp']); ?></h3>
                            <div class="product-price-wrapper">
                                <span class="product-price" style="font-size: 16px; font-weight: 600;">
                                    Xem ngay <i class="fas fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        exit();
    } else {
        echo "<div class='empty-state'>
                <div class='empty-state-icon'>
                    <i class='fas fa-exclamation-triangle'></i>
                </div>
                <h3 class='empty-state-title'>Không có danh mục nào</h3>
                <p class='empty-state-message'>Hiện tại chưa có danh mục sản phẩm nào trong hệ thống.</p>
                <a href='index.php' class='empty-state-btn'>Về Trang Chủ</a>
              </div>";
        exit();
    }
}

$id_dm = mysqli_real_escape_string($mysqli, $_GET['id']);

// Xử lý phân trang
if (isset($_GET['trang'])) {
    $page = intval($_GET['trang']);
} else {
    $page = 1;
}

$products_per_page = 9; // 3x3 grid
$begin = ($page - 1) * $products_per_page;

// Lấy thông tin danh mục
$sql_cate = "SELECT * FROM tbl_danhmucqa WHERE tbl_danhmucqa.id_dm = '$id_dm' LIMIT 1";
$query_cate = mysqli_query($mysqli, $sql_cate);
$row_title = mysqli_fetch_array($query_cate);

if (!$row_title) {
    echo "<div class='empty-state'>
            <div class='empty-state-icon'>
                <i class='fas fa-exclamation-triangle'></i>
            </div>
            <h3 class='empty-state-title'>Không tìm thấy danh mục</h3>
            <p class='empty-state-message'>Danh mục bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
            <a href='index.php' class='empty-state-btn'>Về Trang Chủ</a>
          </div>";
    exit();
}

// Đếm tổng số sản phẩm
$sql_count = "SELECT COUNT(*) as total FROM tbl_sanpham WHERE id_dm = '$id_dm'";
$query_count = mysqli_query($mysqli, $sql_count);
$row_count = mysqli_fetch_array($query_count);
$total_products = $row_count['total'];
$total_pages = ceil($total_products / $products_per_page);

// Xử lý sắp xếp
$order_by = "id_sp DESC"; // Mặc định
if (isset($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'price_asc':
            $order_by = "gia_sp ASC";
            break;
        case 'price_desc':
            $order_by = "gia_sp DESC";
            break;
        case 'name_asc':
            $order_by = "ten_sp ASC";
            break;
        case 'name_desc':
            $order_by = "ten_sp DESC";
            break;
        default:
            $order_by = "id_sp DESC";
    }
}

// Lấy sản phẩm
$sql_pro = "SELECT * FROM tbl_sanpham WHERE id_dm = '$id_dm' ORDER BY $order_by LIMIT $begin, $products_per_page";
$query_pro = mysqli_query($mysqli, $sql_pro);
?>

<!-- Link CSS Premium -->
<link rel="stylesheet" href="css/danhmuc-premium.css">

<!-- Category Hero Section - Compact -->
<div class="category-hero">
    <div class="category-hero-content">
        <div class="category-hero-left">
            <div class="category-breadcrumb">
                <a href="index.php">
                    <i class="fas fa-home"></i> Trang chủ
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Danh mục</span>
                <i class="fas fa-chevron-right"></i>
                <span><?php echo htmlspecialchars($row_title['name_sp']); ?></span>
            </div>
            
            <h1 class="category-hero-title"><?php echo htmlspecialchars($row_title['name_sp']); ?></h1>
            
            <p class="category-hero-description">
                Khám phá bộ sưu tập <?php echo htmlspecialchars($row_title['name_sp']); ?> cao cấp với thiết kế hiện đại, 
                chất lượng vượt trội và phong cách độc đáo.
            </p>
        </div>
        
        <div class="category-hero-stats">
            <div class="category-stat">
                <span class="category-stat-number"><?php echo $total_products; ?></span>
                <span class="category-stat-label">Sản phẩm</span>
            </div>
            <div class="category-stat">
                <span class="category-stat-number">100%</span>
                <span class="category-stat-label">Chính hãng</span>
            </div>
            <div class="category-stat">
                <span class="category-stat-number">24/7</span>
                <span class="category-stat-label">Hỗ trợ</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Layout -->
<div class="category-layout">
    <!-- Sidebar Filters -->
    <aside class="sidebar-premium">
        <div class="filter-card">
            <div class="filter-header" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true">
                <div>
                    <h3 class="filter-title-text">Bộ lọc</h3>
                    <p class="filter-subtitle">Tùy chỉnh tìm kiếm</p>
                </div>
                <div class="filter-icon">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            
            <div class="collapse show" id="filterCollapse">
                <div class="filter-body">
                    <form method="GET" action="index.php" class="filter-form">
                        <input type="hidden" name="quanly" value="timKiemNangCao">
                        <input type="hidden" name="id" value="<?php echo $id_dm; ?>">
                        
                        <div class="form-group">
                            <label for="danhmuc">Danh mục</label>
                            <select name="danhmuc" id="danhmuc" class="form-select">
                                <option value="">Tất cả danh mục</option>
                                <?php
                                $sql_all_cate = "SELECT * FROM tbl_danhmucqa ORDER BY name_sp ASC";
                                $query_all_cate = mysqli_query($mysqli, $sql_all_cate);
                                while ($cat = mysqli_fetch_array($query_all_cate)) {
                                    $selected = ($cat['id_dm'] == $id_dm) ? 'selected' : '';
                                    echo "<option value='" . $cat['id_dm'] . "' $selected>" . htmlspecialchars($cat['name_sp']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="gia_min">Khoảng giá</label>
                            <div class="price-range">
                                <input type="number" name="gia_min" id="gia_min" placeholder="Từ" class="form-control" 
                                       value="<?php echo isset($_GET['gia_min']) ? htmlspecialchars($_GET['gia_min']) : ''; ?>">
                                <span class="price-separator">-</span>
                                <input type="number" name="gia_max" id="gia_max" placeholder="Đến" class="form-control"
                                       value="<?php echo isset($_GET['gia_max']) ? htmlspecialchars($_GET['gia_max']) : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="tinhtrang">Tình trạng</label>
                            <select name="tinhtrang" id="tinhtrang" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="1" <?php echo (isset($_GET['tinhtrang']) && $_GET['tinhtrang'] == '1') ? 'selected' : ''; ?>>
                                    Còn hàng
                                </option>
                                <option value="0" <?php echo (isset($_GET['tinhtrang']) && $_GET['tinhtrang'] == '0') ? 'selected' : ''; ?>>
                                    Hết hàng
                                </option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="ten_sp">Tìm kiếm</label>
                            <input type="text" name="ten_sp" id="ten_sp" placeholder="Nhập tên sản phẩm..." class="form-control"
                                   value="<?php echo isset($_GET['ten_sp']) ? htmlspecialchars($_GET['ten_sp']) : ''; ?>">
                        </div>
                        
                        <button type="submit" class="filter-submit-btn">
                            <i class="fas fa-search"></i> Áp dụng bộ lọc
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Products Area -->
    <div class="products-area">
        <!-- Products Toolbar -->
        <div class="products-toolbar">
            <div class="products-count">
                Hiển thị <strong><?php echo min($begin + 1, $total_products); ?>-<?php echo min($begin + $products_per_page, $total_products); ?></strong> 
                trong tổng số <strong><?php echo $total_products; ?></strong> sản phẩm
            </div>
            
            <div class="products-sort">
                <label for="sort">Sắp xếp:</label>
                <select id="sort" onchange="sortProducts(this.value)">
                    <option value="newest">Mới nhất</option>
                    <option value="price_asc">Giá: Thấp đến cao</option>
                    <option value="price_desc">Giá: Cao đến thấp</option>
                    <option value="name_asc">Tên: A-Z</option>
                    <option value="name_desc">Tên: Z-A</option>
                </select>
            </div>
        </div>
        
        <!-- Products Grid -->
        <?php if ($total_products > 0): ?>
            <div class="products-grid-premium">
                <?php while ($row_pro = mysqli_fetch_array($query_pro)): ?>
                    <div class="product-card-premium">
                        <a href="index.php?quanly=sanpham&id=<?php echo $row_pro['id_sp']; ?>" class="text-decoration-none">
                            <div class="product-image-wrapper">
                                <img loading="lazy" 
                                     src="admincp/modules/quanLySanPham/uploads/<?php echo $row_pro['hinh_anh']; ?>" 
                                     alt="<?php echo htmlspecialchars($row_pro['ten_sp']); ?>"
                                     class="product-image-main">
                                
                                <?php 
                                // Kiểm tra khuyến mãi để hiển thị badge
                                $promotion_check = getActivePromotion($row_pro['id_sp'], $mysqli);
                                if ($promotion_check) {
                                    ?>
                                    <span class="product-badge" style="background: #e74c3c;">
                                        <?php 
                                        if ($promotion_check['loai_km'] == 'phan_tram') {
                                            echo '-' . round($promotion_check['gia_tri_km']) . '%';
                                        } else {
                                            echo 'SALE';
                                        }
                                        ?>
                                    </span>
                                    <?php
                                } elseif ($row_pro['tinh_trang'] == 1) {
                                    ?>
                                    <span class="product-badge">Mới</span>
                                    <?php
                                } else {
                                    ?>
                                    <span class="product-badge out-of-stock">Hết hàng</span>
                                    <?php
                                }
                                ?>
                                
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
                                <div class="product-category"><?php echo htmlspecialchars($row_title['name_sp']); ?></div>
                                <h3 class="product-name"><?php echo htmlspecialchars($row_pro['ten_sp']); ?></h3>
                                
                                <?php
                                // Kiểm tra và hiển thị giá khuyến mãi
                                $promotion = getActivePromotion($row_pro['id_sp'], $mysqli);
                                if ($promotion) {
                                    $gia_km = calculatePromotionPrice($row_pro['gia_sp'], $promotion);
                                    ?>
                                    <div class="product-price-wrapper">
                                        <span class="product-price-original" style="text-decoration: line-through; color: #999; font-size: 0.85em; display: block;">
                                            <?php echo number_format($row_pro['gia_sp'], 0, ',', '.'); ?>₫
                                        </span>
                                        <span class="product-price" style="color: #e74c3c; font-weight: bold;">
                                            <?php echo number_format($gia_km, 0, ',', '.'); ?>₫
                                        </span>
                                        <span class="discount-badge" style="background: #e74c3c; color: white; padding: 2px 6px; border-radius: 3px; font-size: 0.75em; margin-left: 5px;">
                                            -<?php echo calculateDiscountPercent($row_pro['gia_sp'], $gia_km); ?>%
                                        </span>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="product-price-wrapper">
                                        <span class="product-price"><?php echo number_format($row_pro['gia_sp'], 0, ',', '.'); ?>₫</span>
                                    </div>
                                    <?php
                                }
                                ?>
                                
                                <?php if ($row_pro['tinh_trang'] == 1): ?>
                                    <div class="product-stock-status in-stock">
                                        <i class="fas fa-check-circle"></i> Còn hàng
                                    </div>
                                <?php else: ?>
                                    <div class="product-stock-status out-of-stock">
                                        <i class="fas fa-times-circle"></i> Hết hàng
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination-premium">
                    <?php if ($page > 1): ?>
                        <a href="index.php?quanly=danhmucsanpham&id=<?php echo $id_dm; ?>&trang=<?php echo ($page - 1); ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php else: ?>
                        <span class="disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    <?php endif; ?>
                    
                    <?php
                    // Hiển thị trang
                    $range = 2; // Số trang hiển thị mỗi bên
                    
                    if ($page > $range + 1) {
                        echo '<a href="index.php?quanly=danhmucsanpham&id=' . $id_dm . '&trang=1">1</a>';
                        if ($page > $range + 2) {
                            echo '<span class="disabled">...</span>';
                        }
                    }
                    
                    for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) {
                        if ($i == $page) {
                            echo '<span class="active">' . $i . '</span>';
                        } else {
                            echo '<a href="index.php?quanly=danhmucsanpham&id=' . $id_dm . '&trang=' . $i . '">' . $i . '</a>';
                        }
                    }
                    
                    if ($page < $total_pages - $range) {
                        if ($page < $total_pages - $range - 1) {
                            echo '<span class="disabled">...</span>';
                        }
                        echo '<a href="index.php?quanly=danhmucsanpham&id=' . $id_dm . '&trang=' . $total_pages . '">' . $total_pages . '</a>';
                    }
                    ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="index.php?quanly=danhmucsanpham&id=<?php echo $id_dm; ?>&trang=<?php echo ($page + 1); ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="disabled">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3 class="empty-state-title">Chưa có sản phẩm</h3>
                <p class="empty-state-message">
                    Hiện tại danh mục này chưa có sản phẩm nào. Vui lòng quay lại sau hoặc khám phá các danh mục khác.
                </p>
                <a href="index.php" class="empty-state-btn">Khám phá ngay</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript for Sort Functionality -->
<script>
function sortProducts(sortType) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('sort', sortType);
    urlParams.set('trang', '1'); // Reset to page 1 when sorting
    window.location.href = window.location.pathname + '?' + urlParams.toString();
}

// Preserve sort selection
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const sortValue = urlParams.get('sort');
    if (sortValue) {
        document.getElementById('sort').value = sortValue;
    }
});
</script>
