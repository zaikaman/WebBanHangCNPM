# PowerShell script to add bootstrap-override.css to all admin module files
$files = @(
    "quanLyAdmin\doimatkhau.php",
    "quanLyAdmin\lietke.php", 
    "quanLyAdmin\sua.php",
    "quanLyAdmin\them.php",
    "quanLyBaiViet\lietke.php",
    "quanLyBaiViet\sua.php",
    "quanLyBaiViet\them.php", 
    "quanLyBaiViet\timkiem.php",
    "quanLyDanhMucBaiViet\lietke.php",
    "quanLyDanhMucBaiViet\sua.php",
    "quanLyDanhMucBaiViet\them.php",
    "quanLyDanhMucSanPham\lietke.php",
    "quanLyDanhMucSanPham\sua.php", 
    "quanLyDanhMucSanPham\them.php",
    "quanLyDonHang\lietke.php",
    "quanLyDonHang\timkiem.php",
    "quanLyDonHang\xemDonHang.php",
    "quanLySanPham\sua.php",
    "quanLySanPham\them.php",
    "quanLySanPham\timkiem.php",
    "quanLyTaiKhoanKhachHang\lietke.php",
    "quanLyTaiKhoanKhachHang\sua.php",
    "quanLyTaiKhoanKhachHang\timkiem.php"
)

$basePath = "c:\xampp\htdocs\WebBanHangCNPM\admincp\modules"

foreach ($file in $files) {
    $fullPath = Join-Path $basePath $file
    if (Test-Path $fullPath) {
        $content = Get-Content $fullPath -Raw
        
        # Find Bootstrap 5.3.0 CSS link and add override after it
        $pattern = '(<link href="https://cdn\.jsdelivr\.net/npm/bootstrap@5\.3\.0-alpha1/dist/css/bootstrap\.min\.css" rel="stylesheet">)'
        $replacement = '$1' + "`n" + '<link href="../../css/bootstrap-override.css" rel="stylesheet">'
        
        if ($content -match $pattern) {
            $newContent = $content -replace $pattern, $replacement
            Set-Content $fullPath $newContent -NoNewline
            Write-Host "Updated: $file"
        } else {
            Write-Host "Pattern not found in: $file"
        }
    } else {
        Write-Host "File not found: $fullPath"
    }
}
