<?php
ob_start();
session_start();
include('config/config.php');
if (!isset($_SESSION['dangNhap'])) {
    header('Location:login.php');
    exit();
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

<body class="dashboard-page" style="padding:0 !important; margin:0 !important;">
    <!-- Responsive Navbar with 7TCC branding -->
    <header class="admin-header admin-navbar" style="height:70px; min-height:70px; max-height:70px;">
        <div class="container-fluid px-3 py-0 d-flex flex-nowrap align-items-center justify-content-between" style="height:70px; min-height:70px; max-height:70px;">
            <a class="navbar-brand d-flex align-items-center gap-2 flex-shrink-0 text-white" href="index.php" style="height:70px; min-height:70px; max-height:70px;">
                <span class="fw-bold ms-2 admin-navbar-title">Admin Dashboard</span>
            </a>
            <!-- Always keep user-info and logout in a row, let them shrink/resize responsively -->
            <div class="d-flex align-items-center gap-2 flex-nowrap admin-navbar-block" style="height:70px; min-height:70px; max-height:70px;">
                <div class="user-info-block flex-shrink-1" style="min-width:0;">
                    <span class="navbar-text d-flex align-items-center gap-2 px-2 py-1 rounded user-info flex-nowrap" style="min-width:0;">
                        <i class="fas fa-user-circle fs-4"></i>
                        <span class="d-none d-md-inline">Xin chào,</span>
                        <strong style="min-width:0; word-break:break-word;"><?php echo $_SESSION['dangNhap']; ?></strong>
                    </span>
                </div>
                <div class="logout-block flex-shrink-0 ms-3" style="min-width:0;">
                    <a class="btn btn-danger px-3 py-2 fw-semibold shadow-sm" href="logout.php" style="white-space:nowrap;">
                        <i class="fas fa-sign-out-alt me-1"></i>
                        <span class="d-none d-sm-inline">Đăng xuất</span>
                        <span class="d-inline d-sm-none"><i class="fas fa-sign-out-alt"></i></span>
                    </a>
                </div>
            </div>
        </div>
        <style>
            html, body.dashboard-page {
                padding: 0 !important;
                margin: 0 !important;
            }
            .admin-header {
                padding: 0 !important;
                margin: 0 !important;
            }
            .admin-navbar {
                background: linear-gradient(90deg, #dc0021 0%, #a90019 100%);
                box-shadow: 0 2px 8px rgba(220,0,33,0.08);
                border-bottom: 2px solid #a90019;
                width: 100%;
                height: 70px;
                min-height: 70px;
                max-height: 70px;
                padding: 0 !important;
            }
            .admin-navbar .navbar-brand {
                color: #fff !important;
                font-weight: 600;
                letter-spacing: 0.5px;
                min-width: 0;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                font-size: 1.25rem;
                height: 70px;
                min-height: 70px;
                max-height: 70px;
                display: flex;
                align-items: center;
            }
            .admin-navbar-title {
                font-size: 1.3rem;
            }
            .admin-navbar .navbar-text.user-info {
                background: rgba(255,255,255,0.08);
                color: #fff;
                font-size: 1rem;
                font-weight: 500;
                transition: background 0.2s;
                min-width: 0;
                flex-wrap: nowrap;
                word-break: break-word;
                padding-top: 0 !important;
                padding-bottom: 0 !important;
                height: 40px;
                align-items: center;
                display: flex;
            }
            .admin-navbar .navbar-text.user-info strong {
                color: #fff;
                font-weight: 700;
                min-width: 0;
                word-break: break-word;
            }
            .admin-navbar .btn-danger {
                background: linear-gradient(135deg, #dc0021 0%, #a90019 100%) !important;
                border: none;
                color: #fff !important;
                font-size: 1rem;
                border-radius: 6px;
                transition: background 0.2s, box-shadow 0.2s;
                min-width: 0;
                white-space: nowrap;
                padding-top: 8px;
                padding-bottom: 8px;
                height: 40px;
                display: flex;
                align-items: center;
            }
            .admin-navbar .btn-danger:hover, .admin-navbar .btn-danger:focus {
                background: linear-gradient(135deg, #a90019 0%, #dc0021 100%) !important;
                box-shadow: 0 4px 15px rgba(220,0,33,0.18) !important;
            }
            .admin-navbar-block {
                min-width: 0;
                gap: 1.5rem;
                height: 70px;
                min-height: 70px;
                max-height: 70px;
                align-items: center;
                flex-wrap: nowrap !important;
                flex-direction: row !important; /* Always row, never column */
                width: auto;
            }
            .logout-block {
                margin-top: 0 !important;
            }
            @media (max-width: 1200px) {
                .admin-navbar-block {
                    gap: 1rem !important;
                }
            }
            /* Remove flex-direction: column for all breakpoints, always row */
            @media (max-width: 991.98px) {
                .admin-navbar-block {
                    /* flex-direction: row !important; */
                    gap: 0.5rem !important;
                    width: auto;
                    height: auto;
                    min-height: unset;
                    max-height: unset;
                }
                .logout-block, .user-info-block {
                    width: auto;
                }
                .admin-navbar .btn-danger {
                    width: auto;
                    margin-top: 0;
                }
                .admin-navbar .navbar-text.user-info {
                    justify-content: flex-start;
                    width: auto;
                    margin-bottom: 0;
                }
                .admin-navbar, .admin-navbar .navbar-brand, .admin-navbar-block {
                    height: auto !important;
                    min-height: unset !important;
                    max-height: unset !important;
                }
            }
            @media (max-width: 768px) {
                .admin-navbar-title {
                    font-size: 1.3rem;
                }
                .admin-navbar .navbar-text.user-info {
                    font-size: 0.95rem;
                }
                .admin-navbar .btn-danger {
                    font-size: 0.95rem;
                    padding: 8px 12px;
                }
            }
            @media (max-width: 576px) {
                .admin-header .container-fluid {
                    flex-direction: row !important;
                    align-items: center !important;
                    justify-content: space-between !important;
                    gap: 0.75rem !important;
                }
                .admin-navbar-title {
                    font-size: 0.9rem !important;
                    margin-bottom: 0 !important;
                    margin-right: 0.75rem !important;
                }
                .admin-navbar-block {
                    align-items: center !important;
                    gap: 0.2rem !important;
                    height: auto !important;
                    min-height: unset !important;
                    max-height: unset !important;
                    width: auto;
                    margin-left: auto !important;
                }
                .user-info-block {
                    width: auto;
                    margin-right: 0.5rem !important;
                }
                .logout-block {
                    width: auto;
                }
                .admin-navbar .navbar-text.user-info {
                    font-size: 0.9rem;
                    margin-bottom: 0 !important;
                }
                .admin-navbar .btn-danger {
                    font-size: 0.9rem;
                    padding: 7px 10px;
                    min-width: 36px;
                    width: 36px;
                    height: 36px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .admin-navbar .btn-danger span,
                .admin-navbar .btn-danger .logout-text {
                    display: none !important;
                }
                .admin-navbar .btn-danger i {
                    margin-right: 0 !important;
                    font-size: 1.1rem;
                }
                .admin-navbar, .admin-navbar .navbar-brand {
                    height: auto !important;
                    min-height: unset !important;
                    max-height: unset !important;
                    
                }
            }
            @media (max-width: 400px) {
                .admin-navbar-title {
                    font-size: 0.9rem;
                }
                .admin-navbar .navbar-text.user-info {
                    font-size: 0.85rem;
                }
                .admin-navbar .btn-danger {
                    font-size: 0.85rem;
                    padding: 6px 8px;
                }
            }
        </style>
    </header>
    <style>
        @media (max-width: 576px) {
            .navbar-brand span {
                font-size: 15px;
            }
            .navbar-text strong {
                font-size: 15px;
            }
            .navbar .btn {
                font-size: 14px;
                padding: 8px 12px;
            }
        }
        @media (max-width: 400px) {
            .navbar-brand img {
                height: 32px;
            }
        }
    </style>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <!-- Navigation Menu - Horizontal -->
        <?php include("modules/menu.php"); ?>
        
        <!-- Dynamic Content -->
        <?php 
        // Check if we should show dashboard or other content
        $showDashboard = !isset($_GET['action']) || empty($_GET['action']) || ($_GET['action'] == 'dashboard');
        
        if ($showDashboard) {
        ?>
        <!-- Dashboard Content -->
        <div class="card mb-4" style="margin-left:1.5rem; margin-right:1.5rem;">
            <div class="card-header">
            </div>
            <div class="card-body px-0 ">
                <?php include("modules/dashboard.php"); ?>
            </div>
        </div>
        <?php 
        } else {
            // Include main routing logic for other pages
            ?>
              <div class="card mb-4" style="margin-left:1.5rem; margin-right:1.5rem;">
                <div class="card-header">
                    <!-- You can add a dynamic title here if needed -->
                </div>
                <div class="card-body px-0 ">
                    <?php include("modules/main.php"); ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>



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
            
            // Only initialize Morris chart if the chart element exists
            var char = null;
            if ($('#chart').length > 0) {
                char = new Morris.Line({
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
                    parseTime: false,
                    resize: true
                });

                // Thêm event listener để chart tự động resize khi cửa sổ thay đổi kích thước
                var resizeTimeout;
                $(window).on('resize', function() {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(function() {
                        // Lấy kích thước container hiện tại
                        var containerWidth = $('#chart').parent().width();
                        var containerHeight = $('#chart').height();
                        
                        // Redraw chart với kích thước mới
                        char.redraw();
                        
                        // Đảm bảo chart fit với container
                        if (containerWidth > 0) {
                            $('#chart svg').attr('width', containerWidth - 40); // Trừ padding
                        }
                    }, 150);
                });
            }

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
                        if (char && typeof char.setData === 'function') {
                            char.setData(data);
                            $('#text-date').text(text);
                        }
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
                        if (char && typeof char.setData === 'function') {
                            char.setData(data);
                            $('#text-date').text(text);
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>