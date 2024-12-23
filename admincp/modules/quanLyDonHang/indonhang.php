<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('../../../tfpdf/tfpdf.php');
require('../../config/config.php');

// Khởi tạo PDF
$pdf = new tFPDF();
$pdf->AddPage("P");

// Set font
$pdf->AddFont('DejaVu','','DejaVuSerif.ttf',true);
$pdf->SetFont('DejaVu','',14);

// Set màu nền cho ô
$pdf->SetFillColor(193,229,253);

// Lấy mã đơn hàng từ URL và kiểm tra
$code = isset($_GET['code']) ? mysqli_real_escape_string($mysqli, $_GET['code']) : '';
if (empty($code)) {
    die('Mã đơn hàng không hợp lệ');
}

// Truy vấn đơn hàng
$sql_lietke_dh = "SELECT * FROM tbl_chitiet_gh, tbl_sanpham WHERE tbl_chitiet_gh.id_sp = tbl_sanpham.id_sp AND tbl_chitiet_gh.ma_gh='".$code."' ORDER BY tbl_chitiet_gh.id_ctgh DESC";
$lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

if (!$lietke_dh) {
    die('Lỗi truy vấn dữ liệu: ' . mysqli_error($mysqli));
}

$pdf->Write(10, 'Đơn hàng của bạn gồm có:');
$pdf->Ln(10);

$width_cell = array(5, 35, 80, 20, 30, 40);

// Header
$pdf->Cell($width_cell[0], 10, 'ID', 1, 0, 'C', true);
$pdf->Cell($width_cell[1], 10, 'Mã hàng', 1, 0, 'C', true);
$pdf->Cell($width_cell[2], 10, 'Tên sản phẩm', 1, 0, 'C', true);
$pdf->Cell($width_cell[3], 10, 'Số lượng', 1, 0, 'C', true);
$pdf->Cell($width_cell[4], 10, 'Giá', 1, 0, 'C', true);
$pdf->Cell($width_cell[5], 10, 'Tổng tiền', 1, 1, 'C', true);

$pdf->SetFillColor(235, 236, 236);
$fill = false;
$i = 0;

// Nội dung
while ($row = mysqli_fetch_array($lietke_dh)) {
    $i++;
    $pdf->Cell($width_cell[0], 10, $i, 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 10, $row['ma_gh'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[2], 10, $row['ten_sp'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[3], 10, $row['so_luong_mua'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[4], 10, number_format($row['gia_sp']), 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[5], 10, number_format($row['so_luong_mua'] * $row['gia_sp']), 1, 1, 'C', $fill);
    $fill = !$fill;
}

$pdf->Write(10, 'Cảm ơn bạn đã đặt hàng tại website của chúng tôi.');
$pdf->Ln(10);
$pdf->Output();
?>
