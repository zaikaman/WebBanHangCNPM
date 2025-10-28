<link rel="stylesheet" type="text/css" href="css/sanpham.css?v=<?php echo time(); ?>">
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
        <div class="product_img">
            <img class="img" src="admincp/modules/quanLySanPham/uploads/<?php echo $info['hinh_anh'] ?>" alt="">
        </div>
        <div class="product_detail">
            <div>
                <p class="ten_sp"><?php echo $info['ten_sp'] ?></p>
                <p class="quantity">Tình trạng : 
                    <span class="text-highlight-red">
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
            ?>
                <li>
                    <a href="index.php?quanly=sanpham&id=<?php echo $row_related['id_sp'] ?>">
                        <div class="product-image-container">
                            <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row_related['hinh_anh'] ?>" alt="<?php echo $row_related['ten_sp'] ?>">
                        </div>
                        <div class="product-info">
                            <p class="title_product"><?php echo $row_related['ten_sp'] ?></p>
                            <p class="price_product"><?php echo number_format($row_related['gia_sp'],0,',','.').'đ'?></p>
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

<script src="js/sanpham.js" defer></script>
