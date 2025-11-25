<?php
// Trang hiển thị tất cả sản phẩm nổi bật (bán chạy nhất)
if (isset($_GET['trang'])) {
    $page = $_GET['trang'];
} else {
    $page = 1;
}

$begin = ($page - 1) * 12;

// Query lấy sản phẩm nổi bật (bán chạy nhất) - dựa trên tổng số lượng đã bán
$sql_pro = "SELECT tbl_sanpham.*, tbl_danhmucqa.name_sp as ten_dm,
            COALESCE(SUM(tbl_chitiet_gh.so_luong_mua), 0) as total_sold
            FROM tbl_sanpham
            INNER JOIN tbl_danhmucqa ON tbl_sanpham.id_dm = tbl_danhmucqa.id_dm
            LEFT JOIN tbl_chitiet_gh ON tbl_sanpham.id_sp = tbl_chitiet_gh.id_sp
            WHERE tbl_sanpham.so_luong > 0
            GROUP BY tbl_sanpham.id_sp
            ORDER BY total_sold DESC, tbl_sanpham.id_sp DESC
            LIMIT $begin, 12";
$featured_pro = mysqli_query($mysqli, $sql_pro);
?>

<div class="main_with_sidebar">
    <?php include("./pages/sidebar/sidebar.php"); ?>
    
    <div class="main_content main_content_with_sidebar">
        <div class="cate_title">
            <h4>Sản Phẩm Nổi Bật - Bán Chạy Nhất</h4>
            <p style="font-size: 14px; color: #666; margin-top: 10px;">
                Những sản phẩm được yêu thích và mua nhiều nhất bởi khách hàng
            </p>
        </div>
        
        <div class="container mt-3">
            <div class="row">
                <?php
                $count = 0;
                while ($row = mysqli_fetch_array($featured_pro)) {
                    $count++;
                    // Kiểm tra khuyến mãi
                    $promotion = getActivePromotion($row['id_sp'], $mysqli);
                    $gia_hien_thi = $row['gia_sp'];
                    $co_khuyen_mai = false;
                    
                    if ($promotion) {
                        $gia_hien_thi = calculatePromotionPrice($row['gia_sp'], $promotion);
                        $co_khuyen_mai = true;
                    }
                ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="product card h-100">
                            <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sp'] ?>" class="text-decoration-none text-dark">
                                <?php if ($co_khuyen_mai): ?>
                                    <div style="position: relative;">
                                        <span style="position: absolute; top: 10px; right: 10px; background: #e74c3c; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; z-index: 10;">
                                            -<?php echo calculateDiscountPercent($row['gia_sp'], $gia_hien_thi); ?>%
                                        </span>
                                        <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" class="card-img-top img-fluid" alt="<?php echo $row['ten_sp'] ?>">
                                    </div>
                                <?php else: ?>
                                    <div style="position: relative;">
                                        <span style="position: absolute; top: 10px; right: 10px; background: #e67e22; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; z-index: 10;">
                                            Hot
                                        </span>
                                        <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" class="card-img-top img-fluid" alt="<?php echo $row['ten_sp'] ?>">
                                    </div>
                                <?php endif; ?>
                                <div class="card-body text-center">
                                    <p class="title_product card-title"><?php echo $row['ten_sp'] ?></p>
                                    <?php if ($co_khuyen_mai): ?>
                                        <p class="price_product card-text" style="margin-bottom: 5px;">
                                            <span style="text-decoration: line-through; color: #999; font-size: 0.9em;">
                                                <?php echo number_format($row['gia_sp'], 0, ',', '.') . 'đ' ?>
                                            </span>
                                        </p>
                                        <p class="price_product card-text text-danger" style="font-weight: bold; font-size: 1.1em;">
                                            <?php echo number_format($gia_hien_thi, 0, ',', '.') . 'đ' ?>
                                        </p>
                                    <?php else: ?>
                                        <p class="price_product card-text text-danger"><?php echo number_format($row['gia_sp'], 0, ',', '.') . 'đ' ?></p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
                }
                
                if ($count == 0) {
                    echo '<p style="text-align: center; width: 100%; padding: 40px 0;">Chưa có sản phẩm nổi bật.</p>';
                }
                ?>
            </div>
        </div>
        
        <div style="clear:both;"></div>
        
        <?php
        // Đếm tổng số sản phẩm để phân trang
        $sql_count = "SELECT COUNT(*) as total FROM tbl_sanpham WHERE so_luong > 0";
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
                            <a href="index.php?quanly=featured&trang=<?php echo $i ?>"><?php echo $i ?></a>
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
