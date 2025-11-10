<?php
// Trang hiển thị tất cả sản phẩm giảm giá nhiều nhất
if (isset($_GET['trang'])) {
    $page = $_GET['trang'];
} else {
    $page = 1;
}

$begin = ($page - 1) * 12;

// Query lấy sản phẩm có khuyến mãi, sắp xếp theo % giảm giá
$sql_pro = "SELECT sp.*, dm.name_sp, km.loai_km, km.gia_tri_km,
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
            LIMIT $begin, 12";
$discount_pro = mysqli_query($mysqli, $sql_pro);
?>

<div class="main_with_sidebar">
    <?php include("./pages/sidebar/sidebar.php"); ?>
    
    <div class="main_content main_content_with_sidebar">
        <div class="cate_title">
            <h4>Sản Phẩm Giảm Giá Nhiều Nhất</h4>
            <p style="font-size: 14px; color: #666; margin-top: 10px;">
                Những sản phẩm đang có chương trình giảm giá hấp dẫn nhất
            </p>
        </div>
        
        <div class="container mt-3">
            <div class="row">
                <?php
                $count = 0;
                while ($row = mysqli_fetch_array($discount_pro)) {
                    $count++;
                    // Tính giá sau khuyến mãi
                    if ($row['loai_km'] == 'phan_tram') {
                        $gia_hien_thi = $row['gia_sp'] * (1 - $row['gia_tri_km'] / 100);
                    } else {
                        $gia_hien_thi = $row['gia_sp'] - $row['gia_tri_km'];
                    }
                ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="product card h-100">
                            <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sp'] ?>" class="text-decoration-none text-dark">
                                <div style="position: relative;">
                                    <span style="position: absolute; top: 10px; right: 10px; background: #e74c3c; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; z-index: 10; font-size: 16px;">
                                        -<?php echo round($row['discount_percent']); ?>%
                                    </span>
                                    <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" class="card-img-top img-fluid" alt="<?php echo $row['ten_sp'] ?>">
                                </div>
                                <div class="card-body text-center">
                                    <p class="title_product card-title"><?php echo $row['ten_sp'] ?></p>
                                    <p class="price_product card-text" style="margin-bottom: 5px;">
                                        <span style="text-decoration: line-through; color: #999; font-size: 0.9em;">
                                            <?php echo number_format($row['gia_sp'], 0, ',', '.') . 'đ' ?>
                                        </span>
                                    </p>
                                    <p class="price_product card-text text-danger" style="font-weight: bold; font-size: 1.1em;">
                                        <?php echo number_format($gia_hien_thi, 0, ',', '.') . 'đ' ?>
                                    </p>
                                    <p style="color: #27ae60; font-weight: 600; margin-top: 10px; font-size: 14px;">
                                        Tiết kiệm: <?php echo number_format($row['gia_sp'] - $gia_hien_thi, 0, ',', '.'); ?>đ
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
                }
                
                if ($count == 0) {
                    echo '<p style="text-align: center; width: 100%; padding: 40px 0;">Hiện chưa có sản phẩm giảm giá.</p>';
                }
                ?>
            </div>
        </div>
        
        <div style="clear:both;"></div>
        
        <?php
        // Đếm tổng số sản phẩm có khuyến mãi để phân trang
        $sql_count = "SELECT COUNT(*) as total 
                      FROM tbl_sanpham sp
                      INNER JOIN tbl_sanpham_khuyenmai spkm ON sp.id_sp = spkm.id_sp
                      INNER JOIN tbl_khuyenmai km ON spkm.id_km = km.id_km
                      WHERE km.trang_thai = 1 
                      AND NOW() BETWEEN km.ngay_bat_dau AND km.ngay_ket_thuc";
        $result_count = mysqli_query($mysqli, $sql_count);
        $row_count_data = mysqli_fetch_array($result_count);
        $row_count = $row_count_data['total'];
        $trang = ceil($row_count / 12);
        
        if ($trang > 1) {
        ?>
            <ul style="display: flex; flex-direction: row; width: 100%; justify-content: center">
                <?php
                for ($i = 1; $i <= $trang; $i++) {
                ?>
                    <div class="phantrang">
                        <div <?php if ($i == $page) { echo 'style="background: #FFFFFF;"'; } ?>>
                            <a href="index.php?quanly=discount&trang=<?php echo $i ?>"><?php echo $i ?></a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </ul>
        <?php
        }
        ?>
    </div>
</div>
