<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('../../../tfpdf/tfpdf.php');
require('../../config/config.php');

// Khởi tạo PDF
$pdf = new tFPDF();
$pdf->AddPage("P");

// Set font - sử dụng DejaVu Sans để hỗ trợ tiếng Việt tốt hơn
$pdf->AddFont('DejaVuSans','','DejaVuSans.ttf',true);
$pdf->AddFont('DejaVuSans','B','DejaVuSans-Bold.ttf',true);
$pdf->SetFont('DejaVuSans','',12);

// Set màu nền cho ô
$pdf->SetFillColor(193,229,253);

// Lấy mã đơn hàng từ URL và kiểm tra
$code = isset($_GET['code']) ? mysqli_real_escape_string($mysqli, $_GET['code']) : '';
if (empty($code)) {
    die('Mã đơn hàng không hợp lệ');
}

// Truy vấn thông tin khách hàng và đơn hàng
$sql_hoadon = "SELECT h.*, d.ten_khachhang, d.dien_thoai, d.dia_chi 
               FROM tbl_hoadon h 
               LEFT JOIN tbl_dangky d ON h.id_khachhang = d.id_dangky 
               WHERE h.ma_gh = '$code'";
$result_hoadon = mysqli_query($mysqli, $sql_hoadon);
$hoadon = mysqli_fetch_array($result_hoadon);

// Truy vấn đơn hàng
$sql_lietke_dh = "SELECT * FROM tbl_chitiet_gh, tbl_sanpham WHERE tbl_chitiet_gh.id_sp = tbl_sanpham.id_sp AND tbl_chitiet_gh.ma_gh='".$code."' ORDER BY tbl_chitiet_gh.id_ctgh DESC";
$lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

if (!$lietke_dh) {
    die('Lỗi truy vấn dữ liệu: ' . mysqli_error($mysqli));
}

// Tiêu đề hóa đơn
$pdf->SetFont('DejaVuSans','B',16);
$pdf->Cell(0, 10, 'HÓA ĐƠN BÁN HÀNG', 0, 1, 'C');
$pdf->SetFont('DejaVuSans','',12);
$pdf->Ln(5);

// Thông tin đơn hàng
$pdf->Write(10, 'Mã đơn hàng: #' . ($hoadon['id_gh'] ? $hoadon['id_gh'] : 'N/A'));
$pdf->Ln(6);
$pdf->Write(10, 'Mã giỏ hàng: ' . $code);
$pdf->Ln(6);
$pdf->Write(10, 'Ngày đặt hàng: ' . ($hoadon['cart_date'] ? date('d/m/Y H:i:s', strtotime($hoadon['cart_date'])) : 'N/A'));
$pdf->Ln(6);

// Trạng thái đơn hàng
$trang_thai_text = '';
if ($hoadon['trang_thai'] == 0) {
    $trang_thai_text = 'Đã xử lý';
} elseif ($hoadon['trang_thai'] == 2) {
    $trang_thai_text = 'Đã hủy';
} else {
    $trang_thai_text = 'Chờ xử lý';
}
$pdf->Write(10, 'Trạng thái: ' . $trang_thai_text);
$pdf->Ln(10);

// Thông tin khách hàng
$pdf->SetFont('DejaVuSans','B',13);
$pdf->Write(10, 'THÔNG TIN KHÁCH HÀNG:');
$pdf->Ln(8);
$pdf->SetFont('DejaVuSans','',11);
$pdf->Write(10, 'Tên khách hàng: ' . ($hoadon['ten_khachhang'] ? $hoadon['ten_khachhang'] : 'Khách vãng lai'));
$pdf->Ln(6);
$pdf->Write(10, 'Số điện thoại: ' . ($hoadon['dien_thoai'] ? $hoadon['dien_thoai'] : 'Không có'));
$pdf->Ln(6);
$pdf->Write(10, 'Địa chỉ: ' . ($hoadon['dia_chi'] ? $hoadon['dia_chi'] : 'Không có'));
$pdf->Ln(10);

// Chi tiết sản phẩm
$pdf->SetFont('DejaVuSans','B',13);
$pdf->Write(10, 'CHI TIẾT SẢN PHẨM:');
$pdf->Ln(8);
$pdf->Ln(8);
// Use a slightly smaller font for the table so numbers fit
$pdf->SetFont('DejaVuSans','',9);

$width_cell = array(6, 24, 64, 16, 28, 48); // give more room for 'Tổng tiền'

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

// Nội dung và tính tổng tiền
$tongtien = 0;
// Helper to estimate number of lines a MultiCell will take using GetStringWidth
function nbLines($pdf, $w, $txt) {
    $s = str_replace("\r", '', trim($txt));
    if ($s === '') return 1;

    // available width inside the cell (MultiCell uses the given width directly)
    $maxw = $w;

    // Split by existing newlines first
    $lines = explode("\n", $s);
    $nl = 0;

    foreach ($lines as $line) {
        $words = preg_split('/(\s+)/u', $line, -1, PREG_SPLIT_DELIM_CAPTURE);
        $curw = 0.0;
        foreach ($words as $word) {
            $wordw = $pdf->GetStringWidth($word);
            if ($curw + $wordw <= $maxw) {
                $curw += $wordw;
            } else {
                if ($wordw > $maxw) {
                    // long word: split by characters
                    $chars = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);
                    $partw = 0.0;
                    foreach ($chars as $ch) {
                        $chw = $pdf->GetStringWidth($ch);
                        if ($partw + $chw > $maxw) {
                            $nl++;
                            $partw = $chw;
                        } else {
                            $partw += $chw;
                        }
                    }
                    $curw = $partw;
                } else {
                    // move to next line
                    $nl++;
                    $curw = $wordw;
                }
            }
        }
        // finish current line
        $nl++;
    }

    return max(1, $nl);
}

while ($row = mysqli_fetch_array($lietke_dh)) {
    $i++;
    $thanhtien = $row['so_luong_mua'] * $row['gia_sp'];
    $tongtien += $thanhtien;

    // Determine how many lines the product name will need
    $lineHeight = 5; // smaller line height to keep rows compact
    $nb = nbLines($pdf, $width_cell[2], $row['ten_sp']);
    $h = $lineHeight * $nb;

    // Save current position
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // ID
    $pdf->Cell($width_cell[0], $h, $i, 1, 0, 'C', $fill);
    // Mã hàng
    $pdf->Cell($width_cell[1], $h, $row['ma_gh'], 1, 0, 'C', $fill);

    // Tên sản phẩm (use MultiCell so it wraps)
    $pdf->SetXY($x + $width_cell[0] + $width_cell[1], $y);
    $pdf->MultiCell($width_cell[2], $lineHeight, $row['ten_sp'], 1, 'L', $fill);

    // Move to the right of the name cell for the remaining columns
    $pdf->SetXY($x + $width_cell[0] + $width_cell[1] + $width_cell[2], $y);
    $pdf->Cell($width_cell[3], $h, $row['so_luong_mua'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[4], $h, number_format($row['gia_sp']), 1, 0, 'R', $fill);
    $pdf->Cell($width_cell[5], $h, number_format($thanhtien), 1, 1, 'R', $fill);

    $fill = !$fill;
}

// Dòng tổng tiền
$pdf->SetFillColor(193,229,253);
$pdf->Cell($width_cell[0] + $width_cell[1] + $width_cell[2] + $width_cell[3] + $width_cell[4], 10, 'TỔNG TIỀN:', 1, 0, 'R', true);
$pdf->SetFont('DejaVuSans','B',12);
$pdf->Cell($width_cell[5], 10, number_format($tongtien) . ' VND', 1, 1, 'R', true);

// Restore font for the rest of the document
$pdf->SetFont('DejaVuSans','',11);

$pdf->Ln(10);
$pdf->Write(10, 'Cảm ơn bạn đã đặt hàng tại website của chúng tôi!');
$pdf->Ln(8);
$pdf->Write(10, 'Mọi thắc mắc xin liên hệ: support@7tcc.vn');
$pdf->Ln(8);
$pdf->Write(10, 'Website: 7TCC.vn');
$pdf->Ln(15);

// Chữ ký và dấu
$pdf->Cell(90, 10, '', 0, 0, 'C');
$pdf->Cell(90, 10, 'Ngày in: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
$pdf->Ln(10);
$pdf->Cell(90, 10, 'KHÁCH HÀNG', 0, 0, 'C');
$pdf->Cell(90, 10, 'NGƯỜI BÁN HÀNG', 0, 1, 'C');
$pdf->Cell(90, 10, '(Ký, ghi rõ họ tên)', 0, 0, 'C');
$pdf->Cell(90, 10, '(Ký, đóng dấu)', 0, 1, 'C');

$pdf->Output();
?>
