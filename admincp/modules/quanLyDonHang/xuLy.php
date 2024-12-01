<?php
include('..//..//config/config.php');

if(isset($_GET['code'])) {
    $code_cart = $_GET['code'];
    $action = $_GET['action'];

    switch($action) {
        case 'process':
            // Update order status to processed
            $sql = "UPDATE tbl_hoadon SET trang_thai = 0 WHERE ma_gh = '$code_cart'";
            $query = mysqli_query($mysqli, $sql);
            
            if($query) {
                header('Location: ../../index.php?action=quanLyDonHang&query=lietke');
            } else {
                echo "Lỗi cập nhật";
            }
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
