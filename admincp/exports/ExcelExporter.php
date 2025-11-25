<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExcelExporter {
    private $spreadsheet;
    private $worksheet;
    private $mysqli;
    
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
        $this->spreadsheet = new Spreadsheet();
        $this->worksheet = $this->spreadsheet->getActiveSheet();
    }
    
    /**
     * Xuất danh sách sản phẩm ra Excel
     */
    public function exportProducts($search = '', $search_field = 'all', $price_min = '', $price_max = '') {
        // Xây dựng câu truy vấn
        $where_clause = "WHERE tbl_sanpham.id_dm = tbl_danhmucqa.id_dm";
        
        if (!empty($search) || !empty($price_min) || !empty($price_max)) {
            if (!empty($search)) {
                $search = mysqli_real_escape_string($this->mysqli, $search);
                switch ($search_field) {
                    case 'ten_sp':
                        $where_clause .= " AND tbl_sanpham.ten_sp LIKE '%$search%'";
                        break;
                    case 'ma_sp':
                        $where_clause .= " AND tbl_sanpham.ma_sp LIKE '%$search%'";
                        break;
                    case 'tinh_trang':
                        $status = ($search == 'kích hoạt' || $search == '1') ? 1 : 0;
                        $where_clause .= " AND tbl_sanpham.tinh_trang = $status";
                        break;
                    default:
                        $where_clause .= " AND (tbl_sanpham.ten_sp LIKE '%$search%' 
                                        OR tbl_sanpham.ma_sp LIKE '%$search%'
                                        OR tbl_sanpham.tom_tat LIKE '%$search%')";
                }
            }
            
            if (!empty($price_min)) {
                $where_clause .= " AND tbl_sanpham.gia_sp >= $price_min";
            }
            if (!empty($price_max)) {
                $where_clause .= " AND tbl_sanpham.gia_sp <= $price_max";
            }
        }
        
        $sql = "SELECT tbl_sanpham.*, tbl_danhmucqa.name_sp as ten_danh_muc 
                FROM tbl_sanpham, tbl_danhmucqa 
                $where_clause 
                ORDER BY id_sp DESC";
        
        $result = mysqli_query($this->mysqli, $sql);
        
        // Thiết lập tiêu đề
        $this->worksheet->setTitle('Danh Sách Sản Phẩm');
        
        // Header
        $headers = [
            'A1' => 'STT',
            'B1' => 'Tên Sản Phẩm', 
            'C1' => 'Mã Sản Phẩm',
            'D1' => 'Giá (VND)',
            'E1' => 'Số Lượng',
            'F1' => 'Còn Lại',
            'G1' => 'Danh Mục',
            'H1' => 'Tóm Tắt',
            'I1' => 'Nội Dung',
            'J1' => 'Trạng Thái',
            'K1' => 'Hình Ảnh'
        ];
        
        foreach ($headers as $cell => $value) {
            $this->worksheet->setCellValue($cell, $value);
        }
        
        // Định dạng header
        $this->formatHeader('A1:K1');
        
        // Dữ liệu
        $row = 2;
        $stt = 1;
        while ($data = mysqli_fetch_array($result)) {
            $this->worksheet->setCellValue('A' . $row, $stt);
            $this->worksheet->setCellValue('B' . $row, $data['ten_sp']);
            $this->worksheet->setCellValue('C' . $row, $data['ma_sp']);
            $this->worksheet->setCellValue('D' . $row, number_format($data['gia_sp'], 0, ',', '.'));
            $this->worksheet->setCellValue('E' . $row, $data['so_luong']);
            $this->worksheet->setCellValue('F' . $row, $data['so_luong_con_lai']);
            $this->worksheet->setCellValue('G' . $row, $data['ten_danh_muc']);
            $this->worksheet->setCellValue('H' . $row, strip_tags($data['tom_tat']));
            $this->worksheet->setCellValue('I' . $row, strip_tags($data['noi_dung']));
            $this->worksheet->setCellValue('J' . $row, $data['tinh_trang'] == 1 ? 'Kích hoạt' : 'Ẩn');
            $this->worksheet->setCellValue('K' . $row, $data['hinh_anh']);
            $row++;
            $stt++;
        }
        
        // Định dạng cột
        $this->autoSizeColumns('A:K');
        $this->formatDataRows('A2:K' . ($row - 1));
        
        return $this->download('danh_sach_san_pham_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
    
    /**
     * Xuất danh sách đơn hàng ra Excel
     */
    public function exportOrders($search = '', $search_field = 'all') {
        // Xây dựng câu truy vấn
        $where_clause = "";
        
        if (!empty($search)) {
            $search = mysqli_real_escape_string($this->mysqli, $search);
            switch ($search_field) {
                case 'ma_gh':
                    $where_clause = " AND tbl_hoadon.ma_gh LIKE '%$search%'";
                    break;
                case 'ten_khachhang':
                    $where_clause = " AND tbl_dangky.ten_khachhang LIKE '%$search%'";
                    break;
                case 'dien_thoai':
                    $where_clause = " AND tbl_dangky.dien_thoai LIKE '%$search%'";
                    break;
                case 'dia_chi':
                    $where_clause = " AND tbl_dangky.dia_chi_chi_tiet LIKE '%$search%'";
                    break;
                case 'trang_thai':
                    if ($search == 'đã xử lý' || $search == '0') {
                        $status = 0;
                    } elseif ($search == 'đã hủy' || $search == '2') {
                        $status = 2;
                    } else {
                        $status = 1;
                    }
                    $where_clause = " AND tbl_hoadon.trang_thai = $status";
                    break;
                default:
                    $where_clause = " AND (tbl_hoadon.ma_gh LIKE '%$search%' 
                                    OR tbl_dangky.ten_khachhang LIKE '%$search%' 
                                    OR tbl_dangky.dien_thoai LIKE '%$search%'
                                    OR tbl_dangky.dia_chi_chi_tiet LIKE '%$search%')";
            }
        }
        
        $sql = "SELECT tbl_hoadon.*, tbl_dangky.ten_khachhang, tbl_dangky.dien_thoai, 
                       tbl_dangky.dia_chi_chi_tiet as dia_chi, tbl_dangky.email 
                FROM tbl_hoadon 
                INNER JOIN tbl_dangky ON tbl_hoadon.id_khachhang = tbl_dangky.id_dangky 
                WHERE 1=1 $where_clause
                ORDER BY tbl_hoadon.id_gh DESC";
        
        $result = mysqli_query($this->mysqli, $sql);
        
        // Thiết lập tiêu đề
        $this->worksheet->setTitle('Danh Sách Đơn Hàng');
        
        // Header
        $headers = [
            'A1' => 'STT',
            'B1' => 'Mã Đơn Hàng',
            'C1' => 'Tên Khách Hàng',
            'D1' => 'Email',
            'E1' => 'Số Điện Thoại',
            'F1' => 'Địa Chỉ',
            'G1' => 'Ngày Đặt',
            'H1' => 'Phương Thức Thanh Toán',
            'I1' => 'Trạng Thái',
            'J1' => 'Tổng Tiền'
        ];
        
        foreach ($headers as $cell => $value) {
            $this->worksheet->setCellValue($cell, $value);
        }
        
        // Định dạng header
        $this->formatHeader('A1:J1');
        
        // Dữ liệu
        $row = 2;
        $stt = 1;
        while ($data = mysqli_fetch_array($result)) {
            // Tính tổng tiền đơn hàng - Sử dụng gia_mua đã lưu (có khuyến mãi)
            // Compute total from order details table. The original project uses
            // `tbl_chitiet_gh` (order items) with saved purchase price (gia_mua).
            // Use LEFT JOIN to avoid errors if a product record is missing.
            $ma_gh_esc = mysqli_real_escape_string($this->mysqli, $data['ma_gh']);
            $sql_total = "SELECT SUM(c.so_luong_mua * COALESCE(c.gia_mua, IFNULL(s.gia_sp,0))) as total 
                         FROM tbl_chitiet_gh c 
                         LEFT JOIN tbl_sanpham s ON c.id_sp = s.id_sp 
                         WHERE c.ma_gh = '$ma_gh_esc'";
            $total_result = mysqli_query($this->mysqli, $sql_total);
            $total_row = mysqli_fetch_array($total_result);
            $total_amount = isset($total_row['total']) && $total_row['total'] !== null ? $total_row['total'] : 0;
            
            $status_text = '';
            switch($data['trang_thai']) {
                case 0: $status_text = 'Đã xử lý'; break;
                case 1: $status_text = 'Chờ xử lý'; break;
                case 2: $status_text = 'Đã hủy'; break;
                default: $status_text = 'Không xác định';
            }
            
            $this->worksheet->setCellValue('A' . $row, $stt);
            $this->worksheet->setCellValue('B' . $row, $data['ma_gh']);
            $this->worksheet->setCellValue('C' . $row, $data['ten_khachhang']);
            $this->worksheet->setCellValue('D' . $row, $data['email']);
            $this->worksheet->setCellValue('E' . $row, $data['dien_thoai']);
            $this->worksheet->setCellValue('F' . $row, $data['dia_chi']);
            $this->worksheet->setCellValue('G' . $row, $data['cart_date']);
            $this->worksheet->setCellValue('H' . $row, $data['cart_payment']);
            $this->worksheet->setCellValue('I' . $row, $status_text);
            $this->worksheet->setCellValue('J' . $row, number_format($total_amount, 0, ',', '.') . ' VND');
            $row++;
            $stt++;
        }
        
        // Định dạng cột
        $this->autoSizeColumns('A:J');
        $this->formatDataRows('A2:J' . ($row - 1));
        
        return $this->download('danh_sach_don_hang_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
    
    /**
     * Xuất danh sách bài viết ra Excel
     */
    public function exportPosts($search = '', $search_field = 'all') {
        // Xây dựng câu truy vấn
        $where_clause = "WHERE tbl_baiviet.id_danhmuc = tbl_danhmuc_baiviet.id_baiviet";
        
        if (!empty($search)) {
            $search = mysqli_real_escape_string($this->mysqli, $search);
            switch ($search_field) {
                case 'tenbaiviet':
                    $where_clause .= " AND tbl_baiviet.tenbaiviet LIKE '%$search%'";
                    break;
                case 'tacgia':
                    $where_clause .= " AND tbl_baiviet.tacgia LIKE '%$search%'";
                    break;
                case 'tinhtrang':
                    $status = ($search == 'kích hoạt' || $search == '1') ? 1 : 0;
                    $where_clause .= " AND tbl_baiviet.tinhtrang = $status";
                    break;
                default:
                    $where_clause .= " AND (tbl_baiviet.tenbaiviet LIKE '%$search%' 
                                    OR tbl_baiviet.tacgia LIKE '%$search%' 
                                    OR tbl_baiviet.noidung LIKE '%$search%'
                                    OR tbl_baiviet.tomtat LIKE '%$search%')";
            }
        }
        
    // `tbl_danhmuc_baiviet` column is `tendanhmuc_baiviet` in the DB dump
    $sql = "SELECT tbl_baiviet.*, tbl_danhmuc_baiviet.tendanhmuc_baiviet as ten_danh_muc 
        FROM tbl_baiviet, tbl_danhmuc_baiviet 
        $where_clause 
        ORDER BY id DESC";
        
        $result = mysqli_query($this->mysqli, $sql);
        
        // Thiết lập tiêu đề
        $this->worksheet->setTitle('Danh Sách Bài Viết');
        
        // Header
        $headers = [
            'A1' => 'STT',
            'B1' => 'Tên Bài Viết',
            'C1' => 'Tác Giả',
            'D1' => 'Danh Mục',
            'E1' => 'Tóm Tắt',
            'F1' => 'Nội Dung',
            'G1' => 'Trạng Thái',
            'H1' => 'Hình Ảnh',
            'I1' => 'Ngày Tạo'
        ];
        
        foreach ($headers as $cell => $value) {
            $this->worksheet->setCellValue($cell, $value);
        }
        
        // Định dạng header
        $this->formatHeader('A1:I1');
        
        // Dữ liệu
        $row = 2;
        $stt = 1;
        while ($data = mysqli_fetch_array($result)) {
            $this->worksheet->setCellValue('A' . $row, $stt);
            $this->worksheet->setCellValue('B' . $row, $data['tenbaiviet']);
            $this->worksheet->setCellValue('C' . $row, $data['tacgia'] ?? '');
            $this->worksheet->setCellValue('D' . $row, $data['ten_danh_muc']);
            $this->worksheet->setCellValue('E' . $row, strip_tags($data['tomtat'] ?? ''));
            $this->worksheet->setCellValue('F' . $row, strip_tags($data['noidung'] ?? ''));
            $this->worksheet->setCellValue('G' . $row, $data['tinhtrang'] == 1 ? 'Kích hoạt' : 'Ẩn');
            $this->worksheet->setCellValue('H' . $row, $data['hinhanh'] ?? '');
            $this->worksheet->setCellValue('I' . $row, date('d/m/Y H:i:s'));
            $row++;
            $stt++;
        }
        
        // Định dạng cột
        $this->autoSizeColumns('A:I');
        $this->formatDataRows('A2:I' . ($row - 1));
        
        return $this->download('danh_sach_bai_viet_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
    
    /**
     * Xuất danh sách khách hàng ra Excel
     */
    public function exportCustomers($search = '', $search_field = 'all') {
        // Xây dựng câu truy vấn
        $where_clause = "";
        
        if (!empty($search)) {
            $search = mysqli_real_escape_string($this->mysqli, $search);
            switch ($search_field) {
                case 'ten_khachhang':
                    $where_clause = " WHERE ten_khachhang LIKE '%$search%'";
                    break;
                case 'email':
                    $where_clause = " WHERE email LIKE '%$search%'";
                    break;
                case 'dien_thoai':
                    $where_clause = " WHERE dien_thoai LIKE '%$search%'";
                    break;
                case 'dia_chi':
                    $where_clause = " WHERE dia_chi_chi_tiet LIKE '%$search%'";
                    break;
                default:
                    $where_clause = " WHERE (ten_khachhang LIKE '%$search%' 
                                    OR email LIKE '%$search%' 
                                    OR dien_thoai LIKE '%$search%'
                                    OR dia_chi_chi_tiet LIKE '%$search%')";
            }
        }
        
        $sql = "SELECT *, dia_chi_chi_tiet as dia_chi FROM tbl_dangky $where_clause ORDER BY id_dangky DESC";
        $result = mysqli_query($this->mysqli, $sql);
        
        // Thiết lập tiêu đề
        $this->worksheet->setTitle('Danh Sách Khách Hàng');
        
        // Header
        $headers = [
            'A1' => 'STT',
            'B1' => 'Tên Khách Hàng',
            'C1' => 'Email',
            'D1' => 'Số Điện Thoại',
            'E1' => 'Địa Chỉ',
            'F1' => 'Ngày Đăng Ký'
        ];
        
        foreach ($headers as $cell => $value) {
            $this->worksheet->setCellValue($cell, $value);
        }
        
        // Định dạng header
        $this->formatHeader('A1:F1');
        
        // Dữ liệu
        $row = 2;
        $stt = 1;
        while ($data = mysqli_fetch_array($result)) {
            $this->worksheet->setCellValue('A' . $row, $stt);
            $this->worksheet->setCellValue('B' . $row, $data['ten_khachhang']);
            $this->worksheet->setCellValue('C' . $row, $data['email']);
            $this->worksheet->setCellValue('D' . $row, $data['dien_thoai']);
            $this->worksheet->setCellValue('E' . $row, $data['dia_chi']);
            $this->worksheet->setCellValue('F' . $row, date('d/m/Y H:i:s', strtotime($data['ngay_dang_ky'] ?? 'now')));
            $row++;
            $stt++;
        }
        
        // Định dạng cột
        $this->autoSizeColumns('A:F');
        $this->formatDataRows('A2:F' . ($row - 1));
        
        return $this->download('danh_sach_khach_hang_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
    
    /**
     * Định dạng header
     */
    private function formatHeader($range) {
        $this->worksheet->getStyle($range)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2E86AB']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);
        
        // Tăng chiều cao hàng header
        $this->worksheet->getRowDimension('1')->setRowHeight(25);
    }
    
    /**
     * Định dạng dữ liệu
     */
    private function formatDataRows($range) {
        $this->worksheet->getStyle($range)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_TOP,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ]
        ]);
    }
    
    /**
     * Tự động điều chỉnh kích thước cột
     */
    private function autoSizeColumns($range) {
        $columns = explode(':', $range);
        $start = $columns[0];
        $end = $columns[1];
        
        for ($col = $start; $col <= $end; $col++) {
            $this->worksheet->getColumnDimension($col)->setAutoSize(true);
            $this->worksheet->getColumnDimension($col)->setWidth(15); // Chiều rộng tối thiểu
        }
    }
    
    /**
     * Tải xuống file Excel
     */
    private function download($filename) {
        try {
            $writer = new Xlsx($this->spreadsheet);
            
            // Thiết lập header để tải xuống
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');
            
            $writer->save('php://output');
            exit;
        } catch (Exception $e) {
            die('Lỗi khi tạo file Excel: ' . $e->getMessage());
        }
    }
}
?>
