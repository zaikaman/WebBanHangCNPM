<div class="clear"></div>
<div class="footer">
    <div class="footer_content">
        <div class="footer_info">
            <p class="title">Thông tin chung</p>
            <a class="info" href="index.php?">Trang chủ</a>
            <a class="info" href="index?quanly=lienhe">Liên hệ</a>
            <a class="info" href="index?quanly=tintuc">Tin tức</a>
        </div>
        <div class="footer_info">
            <p class="title">Danh mục</p>
            <?php
            $sql_danhmuc = "SELECT * FROM tbl_danhmucqa ORDER BY id_dm DESC";
            $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
            while ($row = mysqli_fetch_array($query_danhmuc)) {
            ?>
                <a href="index.php?quanly=danhmucsanpham&id=<?php echo $row['id_dm'] ?>" class="info"><?php echo $row['name_dm'] ?></a>
            <?php
            }
            ?>
        </div>
        <div class="footer_info">
            <p class="title">Thông tin chi tiết</p>
            <a href="index.php?quanly=CSQDC" class="info">Chính sách và quy định chung</a>
            <a href="index.php?quanly=QDHTTT" class="info">Quy định và hình thức thanh toán</a>
            <a href="index.php?quanly=CSVC" class="info">Chính sách vận chuyển, giao nhận</a>
            <a href="index.php?quanly=CSBH" class="info">Chính sách bảo hành</a>
            <a href="index.php?quanly=CSDT" class="info">Chính sách đổi trả sản phẩm</a>
            <a href="index.php?quanly=CSBM" class="info">Chính sách bảo mật</a>
        </div>
    </div>
</div>

