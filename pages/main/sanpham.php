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