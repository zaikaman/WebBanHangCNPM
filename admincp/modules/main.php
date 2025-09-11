<div class="container-fluid">
    <?php
    if (isset($_GET['action']) && isset($_GET['query'])) {
        $tam = $_GET['action'];
        $query = $_GET['query'];
    } elseif (isset($_GET['action'])) {
        $tam = $_GET['action'];
        $query = "";
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
        include("modules/quanLySanPham/lietke.php");
    } elseif ($tam == 'quanLySanPham' && $query == 'lietke') {
        include("modules/quanLySanPham/lietke.php");
    } elseif ($tam == 'quanLySanPham' && $query == '') {
        include("modules/quanLySanPham/lietke.php");
    } elseif ($tam == 'quanLySanPham' && $query == 'sua') {
        include("modules/quanLySanPham/sua.php");
    } elseif ($tam == 'quanLySanPham' && $query == 'timkiem') {
        include("modules/quanLySanPham/timkiem.php");
    } elseif ($tam == 'quanLyDonHang' && $query == 'lietke') {
        include("modules/quanLyDonHang/lietke.php");
    } elseif ($tam == 'quanLyDonHang' && $query == 'timkiem') {
        include("modules/quanLyDonHang/timkiem.php");
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
    } elseif ($tam == 'quanLyBaiViet' && $query == 'lietke') {
        include("modules/quanLyBaiViet/lietke.php");
    } elseif ($tam == 'quanLyBaiViet' && $query == 'sua') {
        include("modules/quanLyBaiViet/sua.php");
    } elseif ($tam == 'quanLyBaiViet' && $query == 'timkiem') {
        include("modules/quanLyBaiViet/timkiem.php");
    } elseif ($tam == 'quanLyWeb') {
        include("modules/thongTinWeb/quanly.php");
    } elseif ($tam == 'quanLyAdmin' && $query == 'lietke') {
        include('modules/quanLyAdmin/lietke.php');
    } elseif ($tam == 'quanLyAdmin' && $query == 'them') {
        include('modules/quanLyAdmin/them.php');
        include('modules/quanLyAdmin/lietke.php');
    } elseif ($tam == 'quanLyAdmin' && $query == 'sua') {
        include('modules/quanLyAdmin/sua.php');
    } elseif ($tam == 'quanLyAdmin' && $query == 'doimatkhau') {
        include('modules/quanLyAdmin/doimatkhau.php');
    } elseif ($tam == 'quanLyTaiKhoanKhachHang' && $query == 'lietke') {
        include('modules/quanLyTaiKhoanKhachHang/lietke.php');
    } elseif ($tam == 'quanLyTaiKhoanKhachHang' && $query == 'timkiem') {
        include('modules/quanLyTaiKhoanKhachHang/timkiem.php');
    } else {
        // Default case - redirect to dashboard
        echo '<script>window.location.href = "index.php";</script>';
    }
    ?>
</div>
