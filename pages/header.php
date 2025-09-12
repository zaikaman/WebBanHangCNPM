<?php
if (isset($_GET['dangXuat']) && $_GET['dangXuat'] == 1) {
    if (isset($_SESSION['dang_ky'])) {
        $id_dangky = $_SESSION['id_khachhang'];
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $value) {
                $id_sp = $value['id'];
                $so_luong = $value['so_luong'];
                $insert_order_details = "INSERT INTO tbl_giohangtam(id_khachhang,id_sanpham,so_luong) 
                                         VALUE('" . $id_dangky . "','" . $id_sp . "','" . $so_luong . "')";
                mysqli_query($mysqli, $insert_order_details);
            }
        }
        unset($_SESSION['cart']);
    }
    unset($_SESSION['dang_ky']);
}
?>
<div class="header">
    <!-- <img src="images/banner-ao-da-bong.png" width="100%" height="170px"/> -->
    <div class="header_info_container" id="header">
        <div class="header_info">
            <p>Shopee : <a href="https://shopee.vn/">tại đây</a></p>
            <p style="margin-left : 10px">Hotline : <span style="color :yellow">0909888888</span></p>
            <p style="margin-left : 10px">Youtube : <a href="https://www.youtube.com/watch?v=fSVmM71LTOI">tại đây</a></p>
        </div>
    </div>
    <div class="header_content_container">
        <div class="header_content">
            <div class="logo"><a style="cursor : pointer; padding-top : 12px" href="index.php"><img src="images/image7tcc2removebgpreview11884-0kr5-200h.png" alt="7TCC LOGO" width="200px" height="70px"></a></div>
            
            <div class="search_container">
                <form class="search_form" action="index.php?quanly=timKiem" method="POST">
                    <input class="search_input" type="text" name="tuKhoa" id="search-box" placeholder="Bạn cần tìm gì hôm nay ?">
                    <button class="search_btn" type="submit" name="timKiem" class="icon_container">
                        <img src="images/search-icon.svg" alt="arrow">
                    </button>
                </form>
            </div>
            <div class="hotline none">
                <div class="phone">
                    <img style="margin-top: 8px;" src="images/phone.svg" alt="">
                </div>
                <div class="hotline_info">
                    <p style="margin : 0; font-size : 13px;">0909888888</p>
                    <p style="margin : 0; font-size : 12px;">Tổng đài miễn phí</p>
                </div>
            </div>
            <?php
            if (isset($_SESSION['dang_ky'])) {

            ?>
                <div class="hotline logout">
                    <div class="phone">
                        <img style="margin-top: 8px;" src="images/user.svg" alt="">
                    </div>
                    <div class="hotline_info">
                        <p style="margin : 0 0 1px 0; font-size : 12px;">Xin chào</p>
                        <p style="margin : 0; font-size : 14px; font-style : italic;"><?php print_r($_SESSION['dang_ky']); ?></p>
                    </div>
                    <div class="logout_content" id="logout_content">
                        <a id="logout_button" href="index.php?quanly=thongtinnguoidung" class="logout_button">Thông tin</a>
                        <a id="logout_button" href="index.php?quanly=lichSuDonHang" class="logout_button">Lịch sử đơn hàng</a>
                        <a id="logout_button" href="index.php?quanly=doimatkhau" class="logout_button">Đổi mật khẩu</a>
                        <a id="logout_button" href="index.php?dangXuat=1" class="logout_button">Đăng xuất</a>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <!-- <li><a href="index.php?quanly=dangKy">Đăng Ký</a></li> -->
                <div style=" display : flex;">
                    <a href="index.php?quanly=dangnhap" class="login_button">
                        Đăng nhập
                    </a>
                </div>
            <?php
            }
            ?>
            <a href="index.php?quanly=giohang" class="shopping_cart">
                <div class="cart_icon_container">
                    <img style="margin-top: 8px;" src="images/shopping-bag.svg" alt="">
                </div>
                <?php
                if (isset($_SESSION['cart'])) {
                    $count = count($_SESSION['cart']);
                ?>
                    <span class="number_item_cart"><?php echo $count ?></span>

                <?php } else { ?>
                    <span class="number_item_cart">0</span>
                <?php } ?>
            </a>
        </div>
    </div>
</div>

