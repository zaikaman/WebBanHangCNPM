<?php
require('../../tfpdf/tfpdf.php');
require('../../admincp/config/config.php');

$pdf = new tFPDF();
$pdf->AddPage("0");

// Thiết lập font Unicode để hỗ trợ tiếng Việt
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',10);

// Màu nền cho header
$pdf->SetFillColor(70, 130, 180); // Steel Blue
$pdf->SetTextColor(255, 255, 255); // White text

// Header của hóa đơn - compact
$pdf->Cell(0, 12, '7TCC - THOI TRANG THE THAO', 0, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0); // Black text
$pdf->Ln(2);

// Thông tin công ty - compact
$pdf->SetFont('DejaVu','',8);
$pdf->Cell(0, 6, 'Dia chi: 273 An Duong Vuong, Phuong 3, Quan 5, TP.HCM', 0, 1, 'C');
$pdf->Cell(0, 6, 'Dien thoai: 0938688079 | Email: support@7tcc.vn', 0, 1, 'C');
$pdf->Ln(5);

// Lấy thông tin đơn hàng
$code = $_GET['code'];
$sql_don_hang = "SELECT hd.*, dk.ten_khachhang, dk.email, dk.dien_thoai, 
                gh.dia_chi_chi_tiet, gh.quan_huyen, gh.tinh_thanh, 
                gh.name as ten_nguoi_nhan, gh.phone as sdt_nguoi_nhan 
                FROM tbl_hoadon hd 
                LEFT JOIN tbl_dangky dk ON hd.id_khachhang = dk.id_dangky 
                LEFT JOIN tbl_giaohang gh ON hd.cart_shipping = gh.id_shipping 
                WHERE hd.ma_gh = '$code'";
$don_hang = mysqli_query($mysqli, $sql_don_hang);
$info_don_hang = mysqli_fetch_array($don_hang);

// Thông tin đơn hàng - compact
$pdf->SetFont('DejaVu','',12);
$pdf->SetFillColor(240, 240, 240);
$pdf->Cell(0, 8, 'HOA DON BAN HANG', 0, 1, 'C', true);
$pdf->Ln(3);

$pdf->SetFont('DejaVu','',9);
$pdf->Cell(45, 6, 'Ma don hang: ', 0, 0, 'L');
$pdf->Cell(0, 6, '#' . $code, 0, 1, 'L');

if (isset($info_don_hang['cart_date'])) {
    $pdf->Cell(45, 6, 'Ngay dat hang: ', 0, 0, 'L');
    $pdf->Cell(0, 6, date('d/m/Y H:i:s', strtotime($info_don_hang['cart_date'])), 0, 1, 'L');
}

if (isset($info_don_hang['ten_khachhang'])) {
    $pdf->Cell(45, 6, 'Khach hang: ', 0, 0, 'L');
    $pdf->Cell(0, 6, $info_don_hang['ten_khachhang'], 0, 1, 'L');
}

if (isset($info_don_hang['dien_thoai'])) {
    $pdf->Cell(45, 6, 'Dien thoai: ', 0, 0, 'L');
    $pdf->Cell(0, 6, $info_don_hang['dien_thoai'], 0, 1, 'L');
}

if (isset($info_don_hang['dia_chi_chi_tiet']) || isset($info_don_hang['quan_huyen']) || isset($info_don_hang['tinh_thanh'])) {
    $full_address = '';
    if (!empty($info_don_hang['dia_chi_chi_tiet'])) {
        $full_address .= $info_don_hang['dia_chi_chi_tiet'];
    }
    if (!empty($info_don_hang['quan_huyen'])) {
        $full_address .= ($full_address ? ', ' : '') . $info_don_hang['quan_huyen'];
    }
    if (!empty($info_don_hang['tinh_thanh'])) {
        $full_address .= ($full_address ? ', ' : '') . $info_don_hang['tinh_thanh'];
    }
    
    if ($full_address) {
        $pdf->Cell(45, 6, 'Dia chi giao: ', 0, 0, 'L');
        $pdf->Cell(0, 6, $full_address, 0, 1, 'L');
    }
}

$pdf->Ln(6);

// Chi tiết sản phẩm - compact - Sử dụng gia_mua đã lưu (có khuyến mãi nếu có)
$sql_lietke_dh = "SELECT tbl_chitiet_gh.*, tbl_sanpham.ten_sp, tbl_sanpham.ma_sp, 
                  COALESCE(tbl_chitiet_gh.gia_mua, tbl_sanpham.gia_sp) as gia_sp 
                  FROM tbl_chitiet_gh 
                  INNER JOIN tbl_sanpham ON tbl_chitiet_gh.id_sp = tbl_sanpham.id_sp 
                  WHERE tbl_chitiet_gh.ma_gh='".$code."' ORDER BY tbl_chitiet_gh.id_ctgh DESC ";
$lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

$pdf->SetFont('DejaVu','',10);
$pdf->Write(8, 'CHI TIET DON HANG:');
$pdf->Ln(5);

// Header bảng - compact
$pdf->SetFillColor(70, 130, 180);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('DejaVu','',8);

$width_cell = array(12, 25, 75, 18, 30, 40);

$pdf->Cell($width_cell[0], 8, 'STT', 1, 0, 'C', true);
$pdf->Cell($width_cell[1], 8, 'Ma SP', 1, 0, 'C', true);
$pdf->Cell($width_cell[2], 8, 'Ten san pham', 1, 0, 'C', true);
$pdf->Cell($width_cell[3], 8, 'So luong', 1, 0, 'C', true); 
$pdf->Cell($width_cell[4], 8, 'Don gia', 1, 0, 'C', true);
$pdf->Cell($width_cell[5], 8, 'Thanh tien', 1, 1, 'C', true); 

// Nội dung bảng - compact
$pdf->SetFillColor(248, 249, 250); 
$pdf->SetTextColor(0, 0, 0);
$fill = false;
$i = 0;
$tong_tien = 0;

while($row = mysqli_fetch_array($lietke_dh)){
    $i++;
    $thanh_tien = $row['so_luong_mua'] * $row['gia_sp'];
    $tong_tien += $thanh_tien;
    
    $pdf->Cell($width_cell[0], 8, $i, 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 8, $row['ma_sp'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[2], 8, $row['ten_sp'], 1, 0, 'L', $fill);
    $pdf->Cell($width_cell[3], 8, $row['so_luong_mua'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[4], 8, number_format($row['gia_sp']) . ' d', 1, 0, 'R', $fill);
    $pdf->Cell($width_cell[5], 8, number_format($thanh_tien) . ' d', 1, 1, 'R', $fill);
    $fill = !$fill;
}

// Tổng tiền - compact
$pdf->SetFillColor(255, 255, 0); // Yellow background
$pdf->SetFont('DejaVu','',9);
$pdf->Cell(array_sum(array_slice($width_cell, 0, 5)), 8, 'TONG TIEN:', 1, 0, 'R', true);
$pdf->Cell($width_cell[5], 8, number_format($tong_tien) . ' d', 1, 1, 'R', true);

$pdf->Ln(8);

// Footer - compact
$pdf->SetFont('DejaVu','',8);
$pdf->Write(6, 'Cam on quy khach da mua hang tai 7TCC!');
$pdf->Ln(5);
$pdf->Write(6, 'Moi thac mac vui long lien he: 0938688079 | Website: 7tcc.vn');

$pdf->Output('HoaDon_' . $code . '.pdf', 'I');
?>