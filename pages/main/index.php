<?php
$sql_pro = "SELECT * FROM tbl_sanpham,tbl_danhmucqa WHERE tbl_sanpham.id_dm=tbl_danhmucqa.id_dm ORDER BY tbl_sanpham.id_sp DESC LIMIT 30";
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
                ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="product card h-100">
                            <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sp'] ?>" class="text-decoration-none text-dark">
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
        <div style="clear:both;"></div>
        <?php
        $sql_page = mysqli_query($mysqli, "SELECT * FROM tbl_sanpham");
        $row_count = mysqli_num_rows($sql_page);
        // tong san pham /     (so o duoi)   = so trang
        $trang = ceil($row_count / 6);
        ?>
        <ul style="display: flex; flex-direction : row; width : 100%; justify-content : center">
            <?php
            for ($i = 1; $i < $trang; $i++) {
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
    </div>
</div>