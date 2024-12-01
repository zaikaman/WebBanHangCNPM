<?php
session_start();
if (!isset($_SESSION['dangNhap'])) {
    header('Location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link rel="stylesheet" type="text/css" href="css/style_admin.css">
        
    <title>Admin Dashboard</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark align-items-center"> <!-- Thêm align-items-center -->
            <a class="navbar-brand pl-3" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto mr-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Welcome Admin</a>
                    </li>
                    <li class="nav-item">
                        <!-- Nút đăng xuất -->
                        <a class="nav-link btn btn-danger text-white" href="logout.php">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </nav>

    <div class="container-fluid mt-3 pt-3 px-3">
            <div class="column">
                <div class="row-md-3">
                    <?php include("modules/menu.php"); ?>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Dashboard Overview</h3>
                        </div>
                        <div class="card-body">
                            <?php include("modules/main.php"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php include("modules/footer.php"); ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            thongke();
            var char = new Morris.Line({
                element: 'chart',
                xkey: 'date',
                ykeys: ['order', 'sale', 'quantily'],
                labels: ['đơn hàng', 'giá', 'số lượng đã bán']
            });

            $('.select_date').change(function () {
                var thoigian = $(this).val();
                var text = '';
                if (thoigian == '7ngay') {
                    text = '7 ngày qua';
                } else if (thoigian == '28ngay') {
                    text = '28 ngày qua';
                } else if (thoigian == '90ngay') {
                    text = '90 ngày qua';
                } else {
                    text = '365 ngày qua';
                }

                $.ajax({
                    url: "modules/thongke.php",
                    method: "POST",
                    dataType: "JSON",
                    data: { thoigian: thoigian },
                    success: function (data) {
                        char.setData(data);
                        $('#text-date').text(text);
                    }
                });
            });

            function thongke() {
                var text = '365 ngày qua';
                $.ajax({
                    url: "modules/thongke.php",
                    method: "POST",
                    dataType: "JSON",
                    success: function (data) {
                        char.setData(data);
                        $('#text-date').text(text);
                    }
                });
            }
        });
    </script>
</body>

</html>
