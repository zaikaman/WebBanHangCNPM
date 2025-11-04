<?php
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
$sql_pro = "SELECT * FROM tbl_sanpham,tbl_danhmucqa WHERE tbl_sanpham.id_dm=tbl_danhmucqa.id_dm ORDER BY tbl_sanpham.id_sp DESC LIMIT $begin,12";
$new_pro = mysqli_query($mysqli, $sql_pro);
// // DEBUGGING CODE START
// if (!$new_pro) {
//     echo "<p style='color:red; text-align:center;'>SQL Error: " . mysqli_error($mysqli) . "</p>";
// } else {
//     $num_rows = mysqli_num_rows($new_pro);
//     echo "<p style='text-align:center;'>DEBUG: Found " . $num_rows . " products.</p>";
//     if ($num_rows == 0) {
//         echo "<p style='color:orange; text-align:center;'>The product query returned 0 results. Is the production database empty?</p>";
//     }
// }
// // DEBUGGING CODE END
?>
<div class="main_with_sidebar">
    <?php
    include("./pages/sidebar/sidebar.php");
    ?>
    <div class="main_content main_content_with_sidebar ">

        <div class="cate_title">
            <h4>Sản phẩm mới nhất</h4>
        </div>
        <div class="container mt-3">
            <div class="row">
                <?php
                while ($row = mysqli_fetch_array($new_pro)) {
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
                                    <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" class="card-img-top img-fluid" alt="<?php echo $row['ten_sp'] ?>">
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
                ?>
            </div>
        </div>
        <div style="clear:both;"></div>
        <?php
        $sql_page = mysqli_query($mysqli, "SELECT * FROM tbl_sanpham");
        $row_count = mysqli_num_rows($sql_page);
        $trang = ceil($row_count / 12);
        ?>
        <ul style="display: flex; flex-direction : row; width : 100%; justify-content : center">
            <?php
            for ($i = 1; $i <= $trang; $i++) {
            ?>
                <div class="phantrang">
                    <div <?php if ($i == $page) {
                            echo 'style="background: #FFFFFF;"';
                        } else {
                            echo '';
                        } ?>><a href="index.php?trang=<?php echo $i ?>"><?php echo $i ?></a></div>
                </div>
            <?php
            }
            ?>
        </ul>
    </div>
</div>
