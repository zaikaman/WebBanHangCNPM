<?php
if(isset($_GET['quanly'])) {
    $des = $_GET['quanly'];
    switch($des) {
        case 'danhmucsanpham':
            include("danhmuc.php");
            break;
        case 'giohang':
            include("giohang.php");
            break;
        case 'vanChuyen':
            include("vanchuyen.php");
            break;
        case 'thongTinThanhToan':
            include("thongtinthanhtoan.php");
            break;
        case 'donHangDaDat':
            include("donhangdadat.php");
            break;
        case 'lichSuDonHang':
            include("lichSuDonHang.php");
            break;
        case 'xemDonHang':
            include("xemdonhang.php");
            break;
        case 'indonhang':
            include("indonhang.php");
            break;
        case 'danhmucbaiviet':
            include("danhmucbaiviet.php");
            break;
        case 'baiviet':
            include("baiviet.php");
            break;
        case 'tintuc':
            include("tintuc.php");
            break;
        case 'lienhe':
            include("lienhe.php");
            break;
        case 'sanpham':
            include("sanpham.php");
            break;
        case 'dangnhap':
            include("dangnhap.php");
            break;
        case 'CSBH':
            include("Thongtinchung/CSBH.php");
            break;
        case 'CSVC':
            include("Thongtinchung/CSVC.php");
            break;
        case 'CSQDC':
            include("Thongtinchung/CSQDC.php");
            break;
        case 'QDHTTT':
            include("Thongtinchung/QDHTTT.php");
            break;
        case 'CSDT':
            include("Thongtinchung/CSDT.php");
            break;
        case 'CSBM':
            include("Thongtinchung/CSBM.php");
            break;
        case 'dangky':
            include("dangky.php");
            break;
        case 'xacnhanemail':
            include("xacnhanemail.php");
            break;
        case 'emaildaxacnhan':
            include("emaildaxacnhan.php");
            break;
        case 'verify':
            include("verify.php");
            break;
        case 'timKiem':
            include("timkiem.php");
            break;
        case 'timKiemNangCao':
            include("timKiemNangCao.php");
            break;
        case 'doimatkhau':
            include("doimatkhau.php");
            break;
        case 'camon':
            include("camon.php");
            break;
        default:
            include("../slideimg.php");
            include("index.php");
            break;
    }
} else {
    // Trang chủ mặc định
    include("../slideimg.php");
    include("index.php");
}
?> 