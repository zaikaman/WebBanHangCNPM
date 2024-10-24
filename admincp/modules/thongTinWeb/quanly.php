<?php
include("config/config.php");
$sql_lh = "SELECT * FROM tbl_lienhe WHERE id = 1";
$query_lh = mysqli_query($mysqli, $sql_lh);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thông tin website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h3 class="text-center mb-4">Quản lý thông tin website</h3>
        <div class="card shadow-sm">
            <div class="card-body">
                <?php while ($dong = mysqli_fetch_array($query_lh)) { ?>
                    <form method="POST" action="modules/thongTinWeb/xuly.php?id=<?php echo $dong['id'] ?>" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="thongtinlienhe" class="form-label">Thông tin liên hệ</label>
                            <textarea class="form-control" id="thongtinlienhe" rows="5" name="thongtinlienhe" style="resize: none;"><?php echo $dong['thongtinlienhe'] ?></textarea>
                        </div>
                        <button type="submit" name="submitlienhe" class="btn btn-primary">Cập nhật</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
