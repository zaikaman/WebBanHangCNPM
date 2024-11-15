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
                    ?>
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                            <div class="product card h-100">
                                <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sp'] ?>" class="text-decoration-none text-dark" data-ajax="true">
                                    <img src="admincp/modules/quanLySanPham/uploads/<?php echo $row['hinh_anh'] ?>" class="card-img-top img-fluid" alt="<?php echo $row['ten_sp'] ?>">
                                    <div class="card-body text-center">
                                        <p class="title_product card-title"><?php echo $row['ten_sp'] ?></p>
                                        <p class="price_product card-text text-danger"><?php echo number_format($row['gia_sp'], 0, ',', ',') . 'vnđ' ?></p>
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