<?php
if (!isset($_GET['id'])) {
    header("Location: ?action=quanlykhuyenmai&query=lietke");
    exit();
}

$id_km = (int)$_GET['id'];

// Lấy thông tin khuyến mãi
$sql_km = "SELECT * FROM tbl_khuyenmai WHERE id_km = $id_km";
$result_km = mysqli_query($mysqli, $sql_km);
$km = mysqli_fetch_array($result_km);

if (!$km) {
    echo "<div class='alert alert-danger'>Không tìm thấy khuyến mãi!</div>";
    exit();
}

// Xử lý thêm/xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_products'])) {
        $product_ids = $_POST['product_ids'] ?? [];
        foreach ($product_ids as $id_sp) {
            $id_sp = (int)$id_sp;
            // Kiểm tra xem đã tồn tại chưa
            $check = mysqli_query($mysqli, "SELECT id FROM tbl_sanpham_khuyenmai WHERE id_sp = $id_sp AND id_km = $id_km");
            if (mysqli_num_rows($check) == 0) {
                mysqli_query($mysqli, "INSERT INTO tbl_sanpham_khuyenmai (id_sp, id_km) VALUES ($id_sp, $id_km)");
            }
        }
        $success = "Đã thêm sản phẩm vào chương trình khuyến mãi!";
    } elseif (isset($_POST['remove_product'])) {
        $id_sp = (int)$_POST['remove_product'];
        mysqli_query($mysqli, "DELETE FROM tbl_sanpham_khuyenmai WHERE id_sp = $id_sp AND id_km = $id_km");
        $success = "Đã xóa sản phẩm khỏi chương trình khuyến mãi!";
    }
}

// Lấy danh sách sản phẩm đã áp dụng
$sql_applied = "SELECT sp.* FROM tbl_sanpham sp 
                INNER JOIN tbl_sanpham_khuyenmai spkm ON sp.id_sp = spkm.id_sp 
                WHERE spkm.id_km = $id_km 
                ORDER BY sp.id_sp DESC";
$applied_products = mysqli_query($mysqli, $sql_applied);

// Lấy danh sách sản phẩm chưa áp dụng
$sql_not_applied = "SELECT sp.*, dm.name_sp as ten_dm FROM tbl_sanpham sp 
                    INNER JOIN tbl_danhmucqa dm ON sp.id_dm = dm.id_dm
                    WHERE sp.id_sp NOT IN (SELECT id_sp FROM tbl_sanpham_khuyenmai WHERE id_km = $id_km)
                    ORDER BY sp.id_sp DESC";
$not_applied_products = mysqli_query($mysqli, $sql_not_applied);
?>

<div class="container-fluid">
    <?php if (isset($success)): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Thông tin khuyến mãi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">
                <?php echo htmlspecialchars($km['ten_km']); ?>
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Loại:</strong> 
                    <?php 
                    switch($km['loai_km']) {
                        case 'phan_tram': echo 'Giảm ' . $km['gia_tri_km'] . '%'; break;
                        case 'tien_mat': echo 'Giảm ' . number_format($km['gia_tri_km'], 0, ',', '.') . 'đ'; break;
                        case 'gia_moi': echo 'Giá mới ' . number_format($km['gia_tri_km'], 0, ',', '.') . 'đ'; break;
                    }
                    ?>
                </div>
                <div class="col-md-5">
                    <strong>Thời gian:</strong> 
                    <?php echo date('d/m/Y H:i', strtotime($km['ngay_bat_dau'])); ?> 
                    đến 
                    <?php echo date('d/m/Y H:i', strtotime($km['ngay_ket_thuc'])); ?>
                </div>
                <div class="col-md-4 text-right">
                    <a href="?action=quanlykhuyenmai&query=lietke" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sản phẩm đã áp dụng -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-check-circle"></i> Sản phẩm đã áp dụng (<?php echo mysqli_num_rows($applied_products); ?>)
                    </h6>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    <?php if (mysqli_num_rows($applied_products) > 0): ?>
                        <div class="list-group">
                            <?php while ($product = mysqli_fetch_array($applied_products)): 
                                // Tính giá sau khuyến mãi
                                $gia_goc = $product['gia_sp'];
                                switch($km['loai_km']) {
                                    case 'phan_tram':
                                        $gia_km = $gia_goc * (1 - $km['gia_tri_km']/100);
                                        break;
                                    case 'tien_mat':
                                        $gia_km = $gia_goc - $km['gia_tri_km'];
                                        break;
                                    case 'gia_moi':
                                        $gia_km = $km['gia_tri_km'];
                                        break;
                                }
                            ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="modules/quanLySanPham/uploads/<?php echo $product['hinh_anh']; ?>" 
                                                 width="50" class="mr-3" alt="">
                                            <div>
                                                <h6 class="mb-1"><?php echo htmlspecialchars($product['ten_sp']); ?></h6>
                                                <small>
                                                    <span class="text-muted" style="text-decoration: line-through;">
                                                        <?php echo number_format($gia_goc, 0, ',', '.'); ?>đ
                                                    </span>
                                                    <span class="text-danger font-weight-bold ml-2">
                                                        <?php echo number_format($gia_km, 0, ',', '.'); ?>đ
                                                    </span>
                                                </small>
                                            </div>
                                        </div>
                                        <form method="POST" class="m-0">
                                            <button type="submit" name="remove_product" value="<?php echo $product['id_sp']; ?>" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Xóa sản phẩm này khỏi chương trình?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted">Chưa có sản phẩm nào được áp dụng</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sản phẩm chưa áp dụng -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-plus-circle"></i> Thêm sản phẩm
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" id="addProductsForm">
                        <div class="mb-3">
                            <input type="text" id="searchProduct" class="form-control" 
                                   placeholder="Tìm kiếm sản phẩm...">
                        </div>
                        <div style="max-height: 500px; overflow-y: auto;" id="productList">
                            <?php if (mysqli_num_rows($not_applied_products) > 0): ?>
                                <?php while ($product = mysqli_fetch_array($not_applied_products)): ?>
                                    <div class="custom-control custom-checkbox mb-2 product-item" 
                                         data-name="<?php echo strtolower($product['ten_sp']); ?>">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="product_<?php echo $product['id_sp']; ?>" 
                                               name="product_ids[]" value="<?php echo $product['id_sp']; ?>">
                                        <label class="custom-control-label" for="product_<?php echo $product['id_sp']; ?>">
                                            <div class="d-flex align-items-center">
                                                <img src="modules/quanLySanPham/uploads/<?php echo $product['hinh_anh']; ?>" 
                                                     width="40" class="mr-2" alt="">
                                                <div>
                                                    <strong><?php echo htmlspecialchars($product['ten_sp']); ?></strong><br>
                                                    <small class="text-muted">
                                                        <?php echo $product['ten_dm']; ?> - 
                                                        <?php echo number_format($product['gia_sp'], 0, ',', '.'); ?>đ
                                                    </small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p class="text-center text-muted">Tất cả sản phẩm đã được áp dụng</p>
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="add_products" class="btn btn-primary btn-block mt-3">
                            <i class="fas fa-plus"></i> Thêm các sản phẩm đã chọn
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tìm kiếm sản phẩm
document.getElementById('searchProduct').addEventListener('keyup', function() {
    const search = this.value.toLowerCase();
    const items = document.querySelectorAll('.product-item');
    
    items.forEach(item => {
        const name = item.getAttribute('data-name');
        if (name.includes(search)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
