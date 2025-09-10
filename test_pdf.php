<?php
// File test để kiểm tra PDF có hoạt động không
require('tfpdf/tfpdf.php');

try {
    $pdf = new tFPDF();
    $pdf->AddPage();
    
    // Test font Unicode
    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    $pdf->SetFont('DejaVu','',12);
    
    $pdf->Cell(0, 10, 'Test PDF - 7TCC', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->Write(10, 'Neu ban thay dong chu nay thi PDF da hoat dong binh thuong!');
    
    $pdf->Output('test.pdf', 'I');
    echo "PDF test thành công!";
} catch (Exception $e) {
    echo "Lỗi PDF: " . $e->getMessage();
}
?>
