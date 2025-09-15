<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Liên Hệ - 7TCC</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/lienhe.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="main_content">
    <div class="container my-3" style="width : 100%">
        <div class="card shadow">
            <div class="card-header text-center">
                <h2><strong>Thông Tin Liên Hệ</strong></h2>
            </div>
            <div class="card-body">
                <?php
                // Truy vấn dữ liệu liên hệ
                $sql_lh = "SELECT * FROM tbl_lienhe WHERE id=1";
                $query_lh = mysqli_query($mysqli, $sql_lh);
    
                while ($row = mysqli_fetch_array($query_lh)) {
                    echo '<div class="contact-info">' . htmlspecialchars_decode($row['thongtinlienhe']) . '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS và jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>