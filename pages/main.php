<?php
header('Content-Encoding: gzip');
header('Cache-Control: private, max-age=3600');

ob_start("ob_gzhandler");

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Nếu là AJAX request, chỉ trả về nội dung chính
    if(isset($_GET['quanly'])) {
        $des = $_GET['quanly'];
        switch($des) {
            case 'danhmucsanpham':
                include("main/danhmuc.php");
                break;
            case 'giohang':
                include("main/giohang.php");
                break;
            case 'vanChuyen':
                include("main/vanchuyen.php");
                break;
            case 'thongTinThanhToan':
                include("main/thongtinthanhtoan.php");
                break;
            case 'donHangDaDat':
                include("main/donhangdadat.php");
                break;
            case 'lichSuDonHang':
                include("main/lichSuDonHang.php");
                break;
            case 'xemDonHang':
                include("main/xemdonhang.php");
                break;
            case 'indonhang':
                include("main/indonhang.php");
                break;
            case 'danhmucbaiviet':
                include("main/danhmucbaiviet.php");
                break;
            case 'baiviet':
                include("main/baiviet.php");
                break;
            case 'tintuc':
                include("main/tintuc.php");
                break;
            case 'lienhe':
                include("main/lienhe.php");
                break;
            case 'sanpham':
                include("main/sanpham.php");
                break;
            case 'dangnhap':
                include("main/dangnhap.php");
                break;
            case 'CSBH':
                include("main/Thongtinchung/CSBH.php");
                break;
            case 'CSVC':
                include("main/Thongtinchung/CSVC.php");
                break;
            case 'CSQDC':
                include("main/Thongtinchung/CSQDC.php");
                break;
            case 'QDHTTT':
                include("main/Thongtinchung/QDHTTT.php");
                break;
            case 'CSDT':
                include("main/Thongtinchung/CSDT.php");
                break;
            case 'CSBM':
                include("main/Thongtinchung/CSBM.php");
                break;
            case 'dangky':
                include("pages/main/dangky.php");
                break;
            case 'xacnhanemail':
                include("pages/main/xacnhanemail.php");
                break;
            case 'emaildaxacnhan':
                include("pages/main/emaildaxacnhan.php");
                break;
            case 'verify':
                include("pages/main/verify.php");
                break;
            case 'timKiem':
                include("main/timkiem.php");
                break;
            case 'timKiemNangCao':
                include("main/timKiemNangCao.php");
                break;
            case 'doimatkhau':
                include("pages/main/doimatkhau.php");
                break;
            case 'camon':
                include("pages/main/camon.php");
                break;
        }
    } else {
        include("slideimg.php");
        include("main/index.php");
    }
} else {
    // Nếu không phải AJAX request, load toàn bộ layout
    echo '<div id="main">';
    if(isset($_GET['quanly'])) {
        $des = $_GET['quanly'];
    } else {
        $des = '';
    }
    if($des == 'danhmucsanpham') {
        include("main/danhmuc.php");
    } elseif($des == 'giohang') {
        include("main/giohang.php");
    } elseif($des == 'vanChuyen') {
        include("main/vanchuyen.php");
    } elseif($des == 'thongTinThanhToan') {
        include("main/thongtinthanhtoan.php");
    } elseif($des == 'donHangDaDat') {
        include("main/donhangdadat.php");
    } elseif($des == 'lichSuDonHang') {
        include("main/lichSuDonHang.php");
    } elseif($des == 'xemDonHang') {
        include("main/xemdonhang.php");
    } elseif($des == 'indonhang') {
        include("main/indonhang.php");
    } elseif($des == 'danhmucbaiviet') {
        include("main/danhmucbaiviet.php");
    } elseif($des == 'baiviet') {
        include("main/baiviet.php");
    } elseif($des == 'tintuc') {
        include("main/tintuc.php");
    } elseif($des == 'lienhe') {
        include("main/lienhe.php");
    } elseif($des == 'sanpham') {
        include("main/sanpham.php");
    } elseif($des == 'dangnhap') {
        include("main/dangnhap.php");
    } elseif($des == 'CSBH') {
        include("main/Thongtinchung/CSBH.php");
    } elseif($des == 'CSVC') {
        include("main/Thongtinchung/CSVC.php");
    } elseif($des == 'CSQDC') {
        include("main/Thongtinchung/CSQDC.php");
    } elseif($des == 'QDHTTT') {
        include("main/Thongtinchung/QDHTTT.php");
    } elseif($des == 'CSDT') {
        include("main/Thongtinchung/CSDT.php");
    } elseif($des == 'CSBM') {
        include("main/Thongtinchung/CSBM.php");
    } elseif($des == 'dangky') {
        include("pages/main/dangky.php");
    } elseif($des == 'xacnhanemail') {
        include("pages/main/xacnhanemail.php");
    } elseif($des == 'emaildaxacnhan') {
        include("pages/main/emaildaxacnhan.php");
    } elseif($des == 'verify') {
        include("pages/main/verify.php");
    } elseif($des == 'timKiem') {
        include("main/timkiem.php");
    } elseif($des == 'timKiemNangCao') {
        include("main/timKiemNangCao.php");
    } elseif($des == 'doimatkhau') {
        include("pages/main/doimatkhau.php");
    } elseif($des == 'camon') {
        include("pages/main/camon.php");
    } else {
        include("slideimg.php");
        include("main/index.php");
    }
    echo '</div>';
}
?>
