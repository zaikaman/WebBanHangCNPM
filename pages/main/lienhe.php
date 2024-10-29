<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Liên Hệ - 7TCC</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 800px;
        }
        .contact-info ul {
            padding-left: 1.2em;
        }
        .card-header h2 {
            font-size: 1.75rem;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="card shadow">
        <div class="card-header text-center bg-primary text-white">
            <h2><strong>Thông Tin Liên Hệ</strong></h2>
        </div>
        <div class="card-body">
            <?php
            // Kết nối đến cơ sở dữ liệu
            $mysqli = new mysqli("localhost", "username", "password", "database_name");
            
            // Kiểm tra kết nối
            if ($mysqli->connect_error) {
                die("Kết nối thất bại: " . $mysqli->connect_error);
            }

            // Truy vấn dữ liệu liên hệ
            $sql_lh = "SELECT * FROM tbl_lienhe WHERE id=1";
            $query_lh = mysqli_query($mysqli, $sql_lh);

            while ($row = mysqli_fetch_array($query_lh)) {
                echo '<div class="contact-info">' . htmlspecialchars_decode($row['thongtinlienhe']) . '</div>';
            }

            // Đóng kết nối
            $mysqli->close();
            ?>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-primary">Gửi yêu cầu hỗ trợ</button>
        </div>
    </div>
</div>

<!-- Bootstrap JS và jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
