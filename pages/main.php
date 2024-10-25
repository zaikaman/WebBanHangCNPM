<div id="main">
    <?php
    if (isset($_GET['quanly'])) {
        $des = $_GET['quanly'];
    } else {
        $des = '';
    }
    if ($des == 'danhmucsanpham') {
        include("main/danhmuc.php");
    } elseif ($des == 'giohang') {
        include("main/giohang.php");
    } elseif ($des == 'vanChuyen') {
        include("main/vanchuyen.php");
    } elseif ($des == 'thongTinThanhToan') {
        include("main/thongtinthanhtoan.php");
    } elseif ($des == 'donHangDaDat') {
        include("main/donhangdadat.php");
    } elseif ($des == 'lichSuDonHang') {
        include("main/lichSuDonHang.php");
    } elseif ($des == 'xemDonHang') {
        include("main/xemdonhang.php");
    } elseif ($des == 'indonhang') {
        include("main/indonhang.php");
    } elseif ($des == 'danhmucbaiviet') {
        include("main/danhmucbaiviet.php");
    } elseif ($des == 'baiviet') {
        include("main/baiviet.php");
    } elseif ($des == 'tintuc') {
        include("main/tintuc.php");
    } elseif ($des == 'lienhe') {
        include("main/lienhe.php");
    } elseif ($des == 'sanpham') {
        include("main/sanpham.php");
    } elseif ($des == 'dangnhap') {
        include("main/dangnhap.php");
    } elseif ($des == 'CSBH') {
        include("main/Thongtinchung/CSBH.php");
    } elseif ($des == 'CSVC') {
        include("main/Thongtinchung/CSVC.php");
    } elseif ($des == 'CSQDC') {
        include("main/Thongtinchung/CSQDC.php");
    } elseif ($des == 'QDHTTT') {
        include("main/Thongtinchung/QDHTTT.php");
    } elseif ($des == 'CSDT') {
        include("main/Thongtinchung/CSDT.php");
    } elseif ($des == 'CSBM') {
        include("main/Thongtinchung/CSBM.php");
    } elseif ($des == 'dangky') {
        include("pages/main/dangky.php");
    } elseif ($des == 'xacnhanemail'){
        include("pages/main/xacnhanemail.php");
    } elseif ($des == 'emaildaxacnhan'){
        include("pages/main/emaildaxacnhan.php");
    } elseif ($des == 'verify'){
        include("pages/main/verify.php");
    }  elseif ($des == 'timKiem') {
        include("main/timkiem.php");
    } elseif ($des == 'timKiemNangCao') {
        include("main/timKiemNangCao.php");
    } elseif ($des == 'doimatkhau') {
        include("pages/main/doimatkhau.php");
    } elseif ($des == 'camon') {
        include("pages/main/camon.php");
    } else {
        include("slideimg.php");
        include("main/index.php");
    }
    ?>
</div>
