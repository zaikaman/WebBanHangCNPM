<head>
    <!-- Link Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">

    <style>
        .nav-link {
            display: flex;
            align-items: center;
            font-size: 16px;
            color: #495057;
            padding: 10px 15px;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 18px;
        }

        .nav-link:hover {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }

        .nav-link.active {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="index.php?action=quanLyAdmin&query=them">
                <i class="fas fa-user-shield"></i> Quản lý Admin
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="index.php?action=quanLyDanhMucSanPham&query=them">
                <i class="fas fa-boxes"></i> Quản lý danh mục sản phẩm
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?action=quanLySanPham&query=them">
                <i class="fas fa-box"></i> Quản lý sản phẩm
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?action=quanLyDanhMucBaiViet&query=them">
                <i class="fas fa-newspaper"></i> Quản lý danh mục bài viết
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?action=quanLyBaiViet&query=them">
                <i class="fas fa-pen"></i> Quản lý bài viết
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?action=quanLyDonHang&query=lietke">
                <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?action=quanLyWeb&query=capnhat">
                <i class="fas fa-cogs"></i> Quản lý website
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="index.php?action=quanLyTaiKhoanKhachHang&query=lietke">
                <i class="fas fa-customer"></i> Quản lý Tài khoản Khách hàng
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link active" href="index.php">
                <i class="fas fa-chart-bar"></i> Thống kê
            </a>
        </li>
    </ul>
</body>
