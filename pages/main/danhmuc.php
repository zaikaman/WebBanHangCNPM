<?php
if (isset($_GET['trang'])) {
    $page = $_GET['trang'];
} else {
    $page = '';
}
if ($page == '' || $page == 1) {
    $begin = 0;
} else {
    $begin = ($page * 8) - 8;
}

$sql_pro = "SELECT * FROM tbl_sanpham WHERE tbl_sanpham.id_dm = '$_GET[id]' ORDER BY tbl_sanpham.id_sp DESC LIMIT $begin,8";
$sql_cate = "SELECT * FROM tbl_danhmucqa WHERE tbl_danhmucqa.id_dm = '$_GET[id]' ORDER BY tbl_danhmucqa.id_dm DESC";
$query_cate = mysqli_query($mysqli, $sql_cate);
$query_pro = mysqli_query($mysqli, $sql_pro);
if ($query_cate) {
    $row_title = mysqli_fetch_array($query_cate);
}
?>
<div class="main_with_sidebar">
    <?php
    include("./pages/sidebar/sidebar.php");
    ?>
    <div class="main_content main_content_with_sidebar">
        <div class="cate_title">
            <h3><?php echo $row_title['name_sp'] ?></h3>
        </div>
        <div class="container mt-3">
            <div class="row">
                <?php
                $count = 0;
                while ($row_pro = mysqli_fetch_array($query_pro)) {
                    $count++;
                ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="product card h-100">
                            <a href="index.php?quanly=sanpham&id=<?php echo $row_pro['id_sp'] ?>" class="text-decoration-none text-dark">
                                <img loading="lazy" src="admincp/modules/quanLySanPham/uploads/<?php echo $row_pro['hinh_anh']  ?>"class="card-img-top img-fluid" alt="<?php echo $row['ten_sp'] ?>">
                                <div class="card-body text-center">
                                    <p class="title_product card-title"><?php echo $row_pro['ten_sp'] ?></p>
                                    <p class="price_product card-text text-danger"><?php echo number_format($row_pro['gia_sp'], 0, ',', ',') . 'vnđ' ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php }
                if ($count == 0) {
                ?>
                    <div class="kosanpham">Chưa có sản phẩm</div>
                <?php  }
                ?>
            </div>
        </div>

        <div style="clear:both;"></div>
        <?php
        $sql_page = mysqli_query($mysqli, "SELECT * FROM tbl_sanpham WHERE id_dm = '$_GET[id]'");
        $row_count = mysqli_num_rows($sql_page);
        $trang = ceil($row_count / 8);
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
                        } ?>><a href="index.php?quanly=danhmucsanpham&id=<?php echo $_GET['id'] ?>&trang=<?php echo $i ?>"><?php echo $i ?></a></div>
                </div>
            <?php
            }
            ?>
        </ul>
    </div>
</div>
