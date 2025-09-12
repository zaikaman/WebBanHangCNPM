<?php
// migrate_sizes.php

// --- Database Connection ---
// Make sure this path is correct relative to where you place the file.
include('admincp/config/config.php'); 

echo "<h1>Bắt đầu quá trình chuyển đổi dữ liệu size...</h1>";

// --- Lấy tất cả sản phẩm là 'Áo' ---
// Chúng ta giả định các sản phẩm có chữ 'Áo' trong tên là sản phẩm cần quản lý size.
$sql_get_products = "SELECT id_sp, ten_sp, so_luong_con_lai FROM tbl_sanpham WHERE ten_sp LIKE '%Áo%'";
$products_query = mysqli_query($mysqli, $sql_get_products);

if (!$products_query) {
    die("<p style='color:red;'>Lỗi khi truy vấn sản phẩm: " . mysqli_error($mysqli) . "</p>");
}

$total_products = mysqli_num_rows($products_query);
echo "<p>Tìm thấy tổng cộng <strong>$total_products</strong> sản phẩm dạng 'Áo' để xử lý.</p>";

$processed_count = 0;
$skipped_count = 0;

// --- Lặp qua từng sản phẩm ---
while ($product = mysqli_fetch_assoc($products_query)) {
    $product_id = $product['id_sp'];
    $product_name = $product['ten_sp'];
    $total_quantity = (int)$product['so_luong_con_lai'];

    echo "<hr><h3>Đang xử lý sản phẩm: '$product_name' (ID: $product_id)</h3>";

    // --- Kiểm tra xem sản phẩm đã có dữ liệu size chưa ---
    $sql_check = "SELECT COUNT(*) as count FROM tbl_sanpham_sizes WHERE id_sp = $product_id";
    $check_query = mysqli_query($mysqli, $sql_check);
    $check_result = mysqli_fetch_assoc($check_query);

    if ($check_result['count'] > 0) {
        echo "<p style='color:orange;'>Sản phẩm này đã có dữ liệu size. Bỏ qua.</p>";
        $skipped_count++;
        continue;
    }

    // --- Phân bổ số lượng cho các size ---
    if ($total_quantity > 0) {
        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
        $num_sizes = count($sizes);
        
        $base_quantity = floor($total_quantity / $num_sizes);
        $remainder = $total_quantity % $num_sizes;

        $size_distribution = [];
        foreach ($sizes as $size) {
            $size_distribution[$size] = $base_quantity;
        }

        // Cộng số lượng còn dư cho các size từ M trở đi để phân bổ đều hơn
        for ($i = 0; $i < $remainder; $i++) {
            $size_distribution[$sizes[($i + 1) % $num_sizes]]++; // Bắt đầu từ M
        }
        
        echo "<p>Tổng số lượng: <strong>$total_quantity</strong>. Phân bổ như sau:</p><ul>";

        // --- Chèn dữ liệu vào bảng tbl_sanpham_sizes ---
        $sql_insert = "INSERT INTO tbl_sanpham_sizes (id_sp, size, so_luong) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($mysqli, $sql_insert);

        if (!$stmt) {
            echo "<p style='color:red;'>Lỗi khi chuẩn bị câu lệnh: " . mysqli_error($mysqli) . "</p>";
            continue;
        }

        foreach ($size_distribution as $size => $quantity) {
            mysqli_stmt_bind_param($stmt, "isi", $product_id, $size, $quantity);
            mysqli_stmt_execute($stmt);
            echo "<li>Size <strong>$size</strong>: $quantity sản phẩm</li>";
        }
        
        mysqli_stmt_close($stmt);
        echo "</ul><p style='color:green;'>Đã thêm dữ liệu size cho sản phẩm này thành công!</p>";
        $processed_count++;

    } else {
        echo "<p style='color:blue;'>Sản phẩm có tổng số lượng là 0. Bỏ qua việc thêm size.</p>";
        $skipped_count++;
    }
}

echo "<hr><h2>Hoàn tất!</h2>";
echo "<p>Đã xử lý và thêm dữ liệu size cho <strong>$processed_count</strong> sản phẩm.</p>";
echo "<p>Đã bỏ qua <strong>$skipped_count</strong> sản phẩm (do đã có dữ liệu hoặc hết hàng).</p>";

mysqli_close($mysqli);
?>