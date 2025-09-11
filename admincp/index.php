<?php
session_start();
include('config/config.php');
if (!isset($_SESSION['dangNhap'])) {
    header('Location:login.php');
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link rel="stylesheet" type="text/css" href="css/style_admin.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-override.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- Override Bootstrap button colors -->
    <style>
        /* Force override Bootstrap primary button color */
        .btn-primary,
        .btn.btn-primary,
        button.btn-primary,
        input[type="submit"].btn-primary,
        .page-link,
        .pagination .page-link {
            background: linear-gradient(135deg, #dc0021 0%, #a90019 100%) !important;
            border-color: #dc0021 !important;
            color: #fff !important;
        }
        
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn.btn-primary:hover,
        .btn.btn-primary:focus,
        .btn.btn-primary:active,
        .page-link:hover,
        .pagination .page-link:hover {
            background: linear-gradient(135deg, #a90019 0%, #dc0021 100%) !important;
            border-color: #a90019 !important;
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(220, 0, 33, 0.3) !important;
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #dc0021 0%, #a90019 100%) !important;
            border-color: #dc0021 !important;
            color: #fff !important;
        }
        
        /* Override focus states that might show blue */
        .form-control:focus,
        .form-select:focus {
            border-color: #dc0021 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 0, 33, 0.25) !important;
        }
    </style>
    
    <title>7TCC Admin Dashboard</title>
    
    <!-- Add 7TCC Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon_io/favicon-16x16.png">
</head>

<body class="dashboard-page">
    <!-- Enhanced Navbar with 7TCC branding - Same as management pages -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="../images/image7tcc2removebgpreview11884-0kr5-200h.png" alt="7TCC" height="40" class="mr-2">
                <span>Admin Dashboard</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="navbar-text mr-3">
                            <i class="fas fa-user-circle mr-2"></i>
                            Xin chào, <strong><?php echo $_SESSION['dangNhap']; ?></strong>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger ml-2" href="logout.php">
                            <i class="fas fa-sign-out-alt mr-1"></i>
                            Đăng xuất
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <!-- Navigation Menu - Horizontal -->
        <?php include("modules/menu.php"); ?>
        
        <!-- Welcome Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="mb-0">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Dashboard Overview - 7TCC
                </h3>
            </div>
            <div class="card-body px-0">
                <?php include("modules/main.php"); ?>
            </div>
        </div>
    </div>

    <?php include("modules/footer.php"); ?>

    <!-- Scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            // Add active class to current nav item
            var currentPath = window.location.search;
            $('.admin-sidebar .nav-link').each(function() {
                if (this.href.indexOf(currentPath) !== -1 && currentPath !== '') {
                    $(this).addClass('active');
                }
            });
            
            // If no specific action, highlight dashboard
            if (!currentPath || currentPath === '') {
                $('.admin-sidebar .nav-link[href="index.php"]').addClass('active');
            }
            
            thongke();
            var char = new Morris.Line({
                element: 'chart',
                xkey: 'date',
                ykeys: ['order', 'sale', 'quantily'],
                labels: ['Đơn hàng', 'Doanh thu (VNĐ)', 'Số lượng bán'],
                lineColors: ['#dc0021', '#ffe300', '#28a745'],
                pointFillColors: ['#dc0021', '#ffe300', '#28a745'],
                pointStrokeColors: ['#a90019', '#ffd700', '#20c997'],
                gridLineColor: '#eee',
                gridTextColor: '#666',
                gridTextSize: 12,
                hideHover: 'auto',
                parseTime: false
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
