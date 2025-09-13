<?php
// Bao gồm file cấu hình cơ sở dữ liệu
include(dirname(__FILE__) . "/../../admincp/config/config.php");

// Xử lý dữ liệu lọc đầu vào từ người dùng
$danhmuc_filter = filter_input(INPUT_GET, 'danhmuc', FILTER_SANITIZE_NUMBER_INT);
$gia_min_filter = filter_input(INPUT_GET, 'gia_min', FILTER_SANITIZE_NUMBER_INT);
$gia_max_filter = filter_input(INPUT_GET, 'gia_max', FILTER_SANITIZE_NUMBER_INT);
$tinh_trang_filter = filter_input(INPUT_GET, 'tinhtrang', FILTER_SANITIZE_SPECIAL_CHARS);
$ten_sp_filter = isset($_GET['ten_sp']) ? trim(urldecode($_GET['ten_sp'])) : '';
?>

<div class="sidebar">
    <div class="filter_content">
        <div class="filter_title" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse" style="cursor: pointer;">
            <p class="title d-flex justify-content-between align-items-center">
                Bộ lọc sản phẩm
                <i class="fas fa-chevron-down"></i>
            </p>
            <p style="margin: 4px 0px;">Lọc nhanh sản phẩm tìm kiếm</p>
        </div>
        <div class="collapse" id="filterCollapse">
            <!-- Form submission via GET method -->
            <form method="GET" action="index.php" id="filterForm" class="mt-3">
                <input type="hidden" name="quanly" value="timKiemNangCao"> <!-- Hidden field to ensure 'quanly=timKiemNangCao' is passed -->

                <div>
                    <label for="danhmuc">Danh mục:</label>
                    <select name="danhmuc" class="form-select">
                        <option value="">Chọn danh mục</option>
                        <?php
                        $sql_cate = "SELECT * FROM tbl_danhmucqa ORDER BY id_dm DESC";
                        $cate = mysqli_query($mysqli, $sql_cate);
                        while ($dm = mysqli_fetch_array($cate)) {
                            echo "<option value='" . $dm['id_dm'] . "'" . ($danhmuc_filter == $dm['id_dm'] ? ' selected' : '') . ">" . htmlspecialchars($dm['name_sp']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mt-2">
                    <label for="gia_min">Giá từ:</label>
                    <input type="number" name="gia_min" placeholder="Giá thấp nhất" class="form-control" value="<?php echo htmlspecialchars($gia_min_filter); ?>">
                    <label for="gia_max" class="mt-1">đến</label>
                    <input type="number" name="gia_max" placeholder="Giá cao nhất" class="form-control" value="<?php echo htmlspecialchars($gia_max_filter); ?>">
                </div>

                <div class="mt-2">
                    <label for="tinhtrang">Tình trạng:</label>
                    <select name="tinhtrang" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="1" <?php echo ($tinh_trang_filter == '1' ? 'selected' : ''); ?>>Còn hàng</option>
                        <option value="0" <?php echo ($tinh_trang_filter == '0' ? 'selected' : ''); ?>>Hết hàng</option>
                    </select>
                </div>

                <div class="mt-2">
                    <label for="ten_sp">Tên sản phẩm:</label>
                    <input type="text" name="ten_sp" placeholder="Tìm kiếm sản phẩm" class="form-control" value="<?php echo htmlspecialchars(trim($ten_sp_filter), ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <button type="submit" class="btn btn-danger w-100 mt-3">Lọc</button>
            </form>
        </div>
    </div>
</div>

<style>
.filter_title .fa-chevron-down {
    transition: transform 0.3s;
}
.filter_title[aria-expanded="true"] .fa-chevron-down {
    transform: rotate(180deg);
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#filterForm');
        
        form.addEventListener('submit', function (event) {
            // Ngăn gửi form mặc định
            event.preventDefault();

            // Tạo một URLSearchParams để chứa các tham số gửi đi
            const params = new URLSearchParams(new FormData(form));

            // Loại bỏ các tham số có giá trị rỗng
            for (let [key, value] of params.entries()) {
                if (!value.trim()) {
                    params.delete(key);
                }
            }

            // Tạo URL mới
            const newURL = `${form.action}?${params.toString()}`;

            // Điều hướng tới URL mới
            window.location.href = newURL;
        });
    });
</script>

</body>

</html>
