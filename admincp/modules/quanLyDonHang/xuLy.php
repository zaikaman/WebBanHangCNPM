<?php
include('..//..//config/config.php');
require('../../../Carbon-3.8.0/autoload.php');

use Carbon\Carbon;

$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
if(isset($_GET['code'])) {
    $code_cart = $_GET['code'];
    $action = $_GET['action'];

    switch($action) {
        case 'process':
            // Update order status to processed
            $sql = "UPDATE tbl_hoadon SET trang_thai = 1 WHERE ma_gh = '$code_cart'";
            $query = mysqli_query($mysqli, $sql);
            
            // Thống kê doanh thu
            $sql_lietke_dh = "SELECT tbl_chitiet_gh.so_luong_mua, tbl_sanpham.gia_sp 
                             FROM tbl_chitiet_gh 
                             INNER JOIN tbl_sanpham ON tbl_chitiet_gh.id_sp = tbl_sanpham.id_sp 
                             WHERE tbl_chitiet_gh.ma_gh = '$code_cart'";
            $query_lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

            if(!$query_lietke_dh) {
                die("Query failed: " . mysqli_error($mysqli));
            }

            $soluongmua = 0;
            $doanhthu = 0;
            
            while($row = mysqli_fetch_array($query_lietke_dh)) {
                $soluongmua += $row['so_luong_mua'];
                $doanhthu += $row['so_luong_mua'] * $row['gia_sp'];
            }

            // Kiểm tra thống kê trong ngày
            $sql_thongke = "SELECT * FROM tbl_thongke WHERE ngaydat = ?";
            $stmt_check = $mysqli->prepare($sql_thongke);
            $stmt_check->bind_param("s", $now);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            if($result->num_rows == 0) {
                // Chưa có thống kê trong ngày - thêm mới
                $sql_insert = "INSERT INTO tbl_thongke (ngaydat, soluongdaban, doanhthu, donhang) VALUES (?, ?, ?, 1)";
                $stmt_insert = $mysqli->prepare($sql_insert);
                $stmt_insert->bind_param("sii", $now, $soluongmua, $doanhthu);
                
                if(!$stmt_insert->execute()) {
                    die("Insert failed: " . $stmt_insert->error);
                }
                $stmt_insert->close();
            } else {
                // Đã có thống kê - cập nhật
                $row_tk = $result->fetch_assoc();
                $soluongban = $row_tk['soluongdaban'] + $soluongmua;
                $doanhthu_moi = $row_tk['doanhthu'] + $doanhthu;
                $donhang = $row_tk['donhang'] + 1;

                $sql_update = "UPDATE tbl_thongke SET soluongdaban = ?, doanhthu = ?, donhang = ? WHERE ngaydat = ?";
                $stmt_update = $mysqli->prepare($sql_update);
                $stmt_update->bind_param("iiis", $soluongban, $doanhthu_moi, $donhang, $now);
                
                if(!$stmt_update->execute()) {
                    die("Update failed: " . $stmt_update->error);
                }
                $stmt_update->close();
            }
            $stmt_check->close();

            header('Location: ../../index.php?action=quanLyDonHang&query=lietke');
            break;

        case 'view':
            // Redirect to order detail page
            header("Location: ../../index.php?action=quanLyDonHang&query=xemdonhang&code=" . $code_cart);
            break;

        case 'print':
            require('../../tfpdf/tfpdf.php');
            
            // Get order details
            $sql_lietke = "SELECT * FROM tbl_cart_details 
                          INNER JOIN tbl_sanpham ON tbl_cart_details.id_sanpham = tbl_sanpham.id_sanpham
                          WHERE tbl_cart_details.code_cart = '$code_cart'";
            $query_lietke = mysqli_query($mysqli, $sql_lietke);

            // Create PDF
            $pdf = new tFPDF();
            $pdf->AddPage();
            $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
            $pdf->SetFont('DejaVu','',14);
            
            // Add content
            $pdf->Cell(190,10,'Chi tiết đơn hàng: '.$code_cart,0,1,'C');
            // ... Add more PDF content ...
            
            $pdf->Output();
            break;
    }
}
?>
