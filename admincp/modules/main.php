<div class="container-fluid">
    <?php
    if (isset($_GET['action']) && $_GET['query']) {
        $tam = $_GET['action'];
        $query = $_GET['query'];
    } else {
        $tam = "";
        $query = "";
    }
    if ($tam == 'quanLyDanhMucSanPham' && $query == 'them') {
        include("modules/quanLyDanhMucSanPham/them.php");
        include("modules/quanLyDanhMucSanPham/lietke.php");
    } elseif ($tam == 'quanLyDanhMucSanPham' && $query == 'sua') {
        include("modules/quanLyDanhMucSanPham/sua.php");
    } elseif ($tam == 'quanLySanPham' && $query == 'them') {
        include("modules/quanLySanPham/them.php");
        include("modules/quanLySanPham/lietke.php");
    } elseif ($tam == 'quanLySanPham' && $query == 'sua') {
        include("modules/quanLySanPham/sua.php");
    } elseif ($tam == 'quanLyDonHang' && $query == 'lietke') {
        include("modules/quanLyDonHang/lietke.php");
    } elseif ($tam == 'donHang' && $query == 'xemDonHang') {
        include("modules/quanLyDonHang/xemDonHang.php");
    } elseif ($tam == 'quanLyDanhMucBaiViet' && $query == 'them') {
        include("modules/quanLyDanhMucBaiViet/them.php");
        include("modules/quanLyDanhMucBaiViet/lietke.php");
    } elseif ($tam == 'quanLyDanhMucBaiViet' && $query == 'sua') {
        include("modules/quanLyDanhMucBaiViet/sua.php");
    } elseif ($tam == 'quanLyBaiViet' && $query == 'them') {
        include("modules/quanLyBaiViet/them.php");
        include("modules/quanLyBaiViet/lietke.php");
    } elseif ($tam == 'quanLyBaiViet' && $query == 'sua') {
        include("modules/quanLyBaiViet/sua.php");
    } elseif ($tam == 'quanLyWeb') {
        include("modules/thongTinWeb/quanly.php");
    } elseif ($tam == 'quanLyAdmin' && $query == 'them') {
        include('modules/quanLyAdmin/lietke.php');
    } elseif ($tam == 'quanLyAdmin' && $query == 'sua') {
        include('modules/quanLyAdmin/sua.php');
    } elseif ($tam == 'quanLyAdmin' && $query == 'doimatkhau') {
        include('modules/quanLyAdmin/doimatkhau.php');
     } 
      //  elseif ($tam == 'quanLyTaiKhoanKhachHang' && $query == 'xuly') {
    // include('modules/quanLyTaiKhoanKhachHang/xuly.php');
    // }
        elseif($tam =='quanLyTaiKhoanKhachHang' && $query =='lietke'){
        include('modules/quanLyTaiKhoanKhachHang/lietke.php');
    }else {
        include("dashboard.php");
    }
    ?>
</div>
