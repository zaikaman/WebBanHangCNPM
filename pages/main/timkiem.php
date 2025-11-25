<?php
// Promotion helper đã được include trong index.php
// Include rating helper
require_once('includes/rating_helper.php');
?>
<div class="main_with_sidebar">
    <?php
        include("./pages/sidebar/sidebar.php");
    ?>
    <div class="main_content main_content_with_sidebar ">
        <?php
        if (isset($_POST['timKiem'])) {
            $tuKhoa = $_POST['tuKhoa'];
        } else {
            $tuKhoa = '';
        }
        $sql_pro = "SELECT * FROM tbl_sanpham WHERE ten_sp LIKE '%" . $tuKhoa . "%'";
        $query_pro = mysqli_query($mysqli, $sql_pro);
        ?>
        <div class="cate_title">
            <h3>Từ khóa tìm kiếm: <?php echo $tuKhoa ?></h3>
        </div>
        <div class="container mt-3">
                <div class="row">
                    <?php
                    while ($row = mysqli_fetch_array($query_pro)) {
                        // Kiểm tra khuyến mãi cho sản phẩm
                        $promotion = getActivePromotion($row['id_sp'], $mysqli);
                        $gia_hien_thi = $row['gia_sp'];
                        $has_promotion = false;
                        
                        if ($promotion) {
                            $gia_hien_thi = calculatePromotionPrice($row['gia_sp'], $promotion);
                            $has_promotion = true;
                        }
                    ?>
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                            <div class="product card h-100 position-relative">
                                <?php if ($has_promotion) { ?>
                                    <span class="badge bg-danger position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                                        <?php 
                                        if ($promotion['loai_km'] == 'phan_tram') {
                                            echo '-' . round($promotion['gia_tri_km']) . '%';
                                        } else {
                                            echo 'SALE';
                                        }
                                        ?>
                                    </span>
                                <?php } ?>
                                <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sp'] ?>" class="text-decoration-none text-dark">
                                    <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" class="card-img-top img-fluid" alt="<?php echo $row['ten_sp'] ?>">
                                    <div class="card-body text-center">
                                        <p class="title_product card-title"><?php echo $row['ten_sp'] ?></p>
                                        <?php if ($has_promotion) { ?>
                                            <p class="price_product card-text">
                                                <span class="text-muted text-decoration-line-through" style="font-size: 0.9em;">
                                                    <?php echo number_format($row['gia_sp'], 0, ',', '.') . 'đ' ?>
                                                </span>
                                                <br>
                                                <span class="text-danger fw-bold">
                                                    <?php echo number_format($gia_hien_thi, 0, ',', '.') . 'đ' ?>
                                                </span>
                                            </p>
                                        <?php } else { ?>
                                            <p class="price_product card-text text-danger"><?php echo number_format($row['gia_sp'], 0, ',', '.') . 'đ' ?></p>
                                        <?php } ?>
                                        
                                        <?php
                                        // Lấy rating thực từ database
                                        $rating_data = getProductRating($row['id_sp'], $mysqli);
                                        ?>
                                        <div class="product-rating" style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 8px;">
                                            <?php echo generateStarsHTML($rating_data['avg_rating'], true, $rating_data['total_reviews']); ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
    </div>
</div>