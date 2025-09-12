<?php
// Get main product info
$sql_pro_info = "SELECT * FROM tbl_sanpham WHERE tbl_sanpham.id_sp = '$_GET[id]' LIMIT 1";
$pro_info_query = mysqli_query($mysqli, $sql_pro_info);
$info = mysqli_fetch_array($pro_info_query);

// Get sizes and quantities for the product from the new table
$sql_sizes = "SELECT size, so_luong FROM tbl_sanpham_sizes WHERE id_sp = '$_GET[id]' ORDER BY FIELD(size, 'S', 'M', 'L', 'XL', 'XXL')";
$sizes_query = mysqli_query($mysqli, $sql_sizes);

$available_sizes = [];
$size_quantities = [];
if ($sizes_query) {
    while ($row = mysqli_fetch_assoc($sizes_query)) {
        // Only add sizes with stock > 0 to the dropdown
        if ($row['so_luong'] > 0) {
            $available_sizes[] = $row;
        }
        // Keep all quantities for the JS map
        $size_quantities[$row['size']] = $row['so_luong'];
    }
}
$is_in_stock = !empty($available_sizes);
?>
<div class="main_content">
    <form class="product_content" method="POST" action="/WebBanHangCNPM/pages/main/themgiohang.php?idsanpham=<?php echo $info['id_sp'] ?>">
        <div class="product_img">
            <img class="img" src="admincp/modules/quanLySanPham/uploads/<?php echo $info['hinh_anh'] ?>" alt="">
        </div>
        <div class="product_detail">
            <div>
                <p class="ten_sp"><?php echo $info['ten_sp'] ?></p>
                <p class="quantity">Tình trạng : 
                    <span style="color : red; font-weight : 500;">
                        <?php echo $is_in_stock ? 'Còn hàng' : 'Hết hàng'; ?>
                    </span>
                </p>
                <p class="gia_sp"><?php echo number_format($info['gia_sp'], 0, ',', ',') . 'đ' ?></p>
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
                <p>Danh mục : <strong><?php echo $category_name; ?></strong></p>
            </div>

            <?php if($is_in_stock): ?>
                <div class="size_selection">
                    <label for="size_select" style="color : #55595C; font-size : 16px">Kích cỡ :</label>
                    <select name="size" id="size_select" class="size_select" style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        <?php foreach ($available_sizes as $size_data): ?>
                            <option value="<?php echo htmlspecialchars($size_data['size']); ?>">
                                <?php echo htmlspecialchars($size_data['size']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="soluong">
                    <label for="soluong_input" style="color : #55595C; font-size : 16px; margin-top: 10px;">Số lượng :</label>
                    <div style="display : block">
                        <button type="button" id="giam" class="soluong_btn">-</button>
                        <input class="soluong_input" id="soluong_input" name="so_luong" type="number" value="1" min="1">
                        <button type="button" id="tang" class="soluong_btn">+</button>
                    </div>
                </div>
            <?php endif; ?>

            <div class="tabs">
                <ul id="tabs-nav">
                    <li><a href="#chitiet">Tóm tắt </a></li>
                    <li><a href="#noidung">Nội dung</a></li>
                </ul>
                <div id="tabs-content">
                    <div id="chitiet" class="tab-content"><?php echo nl2br(str_replace(['
', '
'], "\n", $info['tom_tat'])) ?></div>
                    <div id="noidung" class="tab-content"><?php echo nl2br(str_replace(['
', '
'], "\n", $info['noi_dung'])) ?></div>
                </div>
            </div>

            <?php if ($is_in_stock): ?>
                <?php if (isset($_SESSION['id_khachhang']) && isset($_SESSION['dang_ky'])): ?>
                    <div style="width : 100%; display : flex; align-items : center; justify-content : center">
                        <input class="mua_btn" type="submit" name="themgiohang" value="Thêm vào giỏ hàng">
                    </div>
                <?php else: ?>
                    <div style="width : 100%; display : flex; align-items : center; justify-content : center">
                        <a style="align-items: center; color : white ;" class="mua_btn" href="index.php?quanly=dangnhap">Đăng nhập để mua hàng</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Related Products -->
<div class="related-products">
    <div class="related-products-container">
        <h3 class="related-products-title">Sản phẩm liên quan</h3>
        <ul class="related-product-list">
            <?php
            $id_dm = $info['id_dm'];
            $sql_related = "SELECT * FROM tbl_sanpham WHERE id_dm = '$id_dm' AND id_sp != '$_GET[id]' ORDER BY RAND() LIMIT 5";
            $query_related = mysqli_query($mysqli, $sql_related);
            while ($row_related = mysqli_fetch_array($query_related)) {
            ?>
                <li>
                    <a href="index.php?quanly=sanpham&id=<?php echo $row_related['id_sp'] ?>">
                        <div class="product-image-container">
                            <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row_related['hinh_anh'] ?>" alt="<?php echo $row_related['ten_sp'] ?>">
                        </div>
                        <div class="product-info">
                            <p class="title_product"><?php echo $row_related['ten_sp'] ?></p>
                            <p class="price_product"><?php echo number_format($row_related['gia_sp'],0,',','.').'đ' ?></p>
                        </div>
                    </a>
                    <a href="index.php?quanly=sanpham&id=<?php echo $row_related['id_sp'] ?>" class="view-details-btn">Xem chi tiết</a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>

<style>
/* --- Related Products --- */
.related-products {
    width: 100%;
    margin-top: 50px;
    padding: 30px 0;
    background-color: #f9f9f9; /* A very light grey background for the section */
}

.related-products-container {
    width: 90%; /* Or your site's main container width */
    margin: 0 auto;
}

.related-products-title {
    font-size: 26px;
    font-weight: 700;
    color: #333;
    text-align: center;
    margin-bottom: 30px;
    position: relative;
    padding-bottom: 15px;
}

/* Creates a decorative line under the title */
.related-products-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: #d42333; /* Accent color */
}

.related-product-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; /* Center the products */
    margin: 0 -15px;
    padding: 0;
    list-style: none;
}

.related-product-list li {
    flex: 0 0 calc(20% - 30px);
    max-width: calc(20% - 30px);
    margin: 15px;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative; /* For positioning the hover button */
}

.related-product-list li:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.1);
}

.related-product-list li a {
    display: block;
    text-decoration: none;
}

.product-image-container {
    position: relative;
    overflow: hidden;
}

.related-product-list li img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.related-product-list li:hover img {
    transform: scale(1.05); /* Zoom effect on hover */
}

.product-info {
    padding: 15px;
    text-align: center;
}

.related-product-list li .title_product {
    font-weight: 600;
    color: #333;
    font-size: 16px;
    line-height: 1.4;
    margin-bottom: 10px;
    /* Clamp text to 2 lines */
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 45px; /* 16px * 1.4 * 2 lines */
}

.related-product-list li .price_product {
    font-size: 18px;
    font-weight: 700;
    color: #d42333;
}

.view-details-btn {
    position: absolute;
    bottom: 20px; /* Adjusted position */
    left: 50%;
    transform: translate(-50%, 10px);
    opacity: 0;
    background-color: #333;
    color: #fff;
    padding: 10px 20px; /* Made button larger */
    border-radius: 5px;
    font-size: 14px;
    font-weight: 600; /* Bolder text */
    transition: opacity 0.3s ease, transform 0.3s ease;
    white-space: nowrap;
    pointer-events: none; /* Button is for visual only */
}

.related-product-list li:hover .view-details-btn {
    opacity: 1;
    transform: translate(-50%, 0);
}

/* Hide original product info on hover to show button */
.related-product-list li:hover .product-info {
    opacity: 0;
    transition: opacity 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .related-product-list li { flex-basis: calc(25% - 30px); max-width: calc(25% - 30px); }
}
@media (max-width: 992px) {
    .related-product-list li { flex-basis: calc(33.333% - 30px); max-width: calc(33.333% - 30px); }
}
@media (max-width: 768px) {
    .related-product-list li { flex-basis: calc(50% - 30px); max-width: calc(50% - 30px); }
}
@media (max-width: 576px) {
    .related-product-list li { flex-basis: calc(100% - 30px); max-width: calc(100% - 30px); }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const sizeQuantities = <?php echo json_encode($size_quantities); ?>;
    
    const sizeSelect = document.getElementById("size_select");
    const quantityInput = document.getElementById("soluong_input");
    const btnDecrease = document.getElementById("giam");
    const btnIncrease = document.getElementById("tang");

    function updateMaxQuantity() {
        if (!sizeSelect || !quantityInput) return;
        
        const selectedSize = sizeSelect.value;
        const maxQuantity = sizeQuantities[selectedSize] || 0;
        
        quantityInput.max = maxQuantity;
        
        if (parseInt(quantityInput.value) > maxQuantity) {
            quantityInput.value = 1;
        }
    }

    // Run on page load
    updateMaxQuantity();

    // Add event listeners if elements exist
    if (sizeSelect) {
        sizeSelect.addEventListener("change", function() {
            quantityInput.value = 1;
            updateMaxQuantity();
        });
    }

    if (btnIncrease) {
        btnIncrease.addEventListener("click", function() {
            let currentVal = parseInt(quantityInput.value);
            let maxVal = parseInt(quantityInput.max);
            if (currentVal < maxVal) {
                quantityInput.value = currentVal + 1;
            }
        });
    }

    if (btnDecrease) {
        btnDecrease.addEventListener("click", function() {
            let currentVal = parseInt(quantityInput.value);
            if (currentVal > 1) {
                quantityInput.value = currentVal - 1;
            }
        });
    }
    
    if (quantityInput) {
        quantityInput.addEventListener("input", function() {
            let val = parseInt(this.value);
            let max = parseInt(this.max);
            if (val > max) { this.value = max; }
            if (val < 1) { this.value = 1; }
        });
    }
});
</script>