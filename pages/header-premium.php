<?php
if (isset($_GET['dangXuat']) && $_GET['dangXuat'] == 1) {
    if (isset($_SESSION['dang_ky'])) {
        $id_dangky = $_SESSION['id_khachhang'];
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $value) {
                $id_sp = $value['id'];
                $so_luong = $value['so_luong'];
                $insert_order_details = "INSERT INTO tbl_giohangtam(id_khachhang,id_sanpham,so_luong) 
                                         VALUE('" . $id_dangky . "','" . $id_sp . "','" . $so_luong . "')";
                mysqli_query($mysqli, $insert_order_details);
            }
        }
        unset($_SESSION['cart']);
    }
    unset($_SESSION['dang_ky']);
}
?>

<!-- Premium Header CSS -->
<link rel="stylesheet" href="css/header-premium.css?v=<?php echo time(); ?>">

<div class="header">
    <!-- Top Info Bar -->
    <div class="header_info_container">
        <div class="header_info">
            <div class="header_info_left">
                <p class="header_info_item">
                    <i class="fab fa-shopify"></i>
                    Shopee: <a href="https://shopee.vn/" target="_blank">tại đây</a>
                </p>
                <p class="header_info_item">
                    <i class="fab fa-youtube"></i>
                    Youtube: <a href="https://www.youtube.com/watch?v=fSVmM71LTOI" target="_blank">tại đây</a>
                </p>
            </div>
            <div class="header_info_right">
                <p class="header_info_item">
                    <i class="fas fa-phone-alt"></i>
                    Hotline: <a href="tel:0909888888">0909888888</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="header_content_container" id="mainHeader">
        <div class="header_content">
            <!-- Logo -->
            <div class="logo" style="display: flex !important; visibility: visible !important; opacity: 1 !important; height: 100%; align-items: center;">
                <a href="index.php" style="display: flex !important; height: 100%; align-items: center;">
                    <img src="images/logo.png" 
                         alt="7TCC Logo" 
                         style="display: block !important; visibility: visible !important; height: 70px !important; width: auto !important; max-width: 200px; object-fit: contain;"
                         loading="eager"
                         onerror="console.error('Logo failed to load:', this.src); this.style.border='2px solid red';">
                </a>
            </div>
            
            <!-- Search Bar -->
            <div class="search_container">
                <form class="search_form" action="index.php?quanly=timKiem" method="POST">
                    <input class="search_input" 
                           type="text" 
                           name="tuKhoa" 
                           placeholder="Tìm kiếm sản phẩm, danh mục..."
                           autocomplete="off">
                    <button class="search_btn" type="submit" name="timKiem">
                        <img src="images/search-icon.svg" alt="Search">
                    </button>
                </form>
            </div>

            <!-- Header Actions -->
            <div class="header_actions">
                <!-- Hotline (Desktop) -->
                <a href="tel:0909888888" class="hotline none">
                    <div class="phone">
                        <img src="images/phone.svg" alt="Phone">
                    </div>
                    <div class="hotline_info">
                        <p>Hotline</p>
                        <p>0909888888</p>
                    </div>
                </a>

                <!-- User Section -->
                <?php if (isset($_SESSION['dang_ky'])) { ?>
                    <div class="hotline logout">
                        <div class="phone">
                            <img src="images/user.svg" alt="User">
                        </div>
                        <div class="hotline_info">
                            <p>Xin chào</p>
                            <p><?php echo $_SESSION['dang_ky']; ?></p>
                        </div>
                        <div class="logout_content">
                            <a href="index.php?quanly=thongtinnguoidung" class="logout_button">
                                <i class="fas fa-user-circle"></i> Thông tin tài khoản
                            </a>
                            <a href="index.php?quanly=lichSuDonHang" class="logout_button">
                                <i class="fas fa-history"></i> Lịch sử đơn hàng
                            </a>
                            <a href="index.php?quanly=doimatkhau" class="logout_button">
                                <i class="fas fa-key"></i> Đổi mật khẩu
                            </a>
                            <a href="index.php?dangXuat=1" class="logout_button">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a>
                        </div>
                    </div>
                <?php } else { ?>
                    <a href="index.php?quanly=dangnhap" class="login_button">
                        <i class="fas fa-user"></i>
                        <span>Đăng nhập</span>
                    </a>
                <?php } ?>

                <!-- Shopping Cart -->
                <a href="index.php?quanly=giohang" class="shopping_cart">
                    <div class="cart_icon_container">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <?php
                    $count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                    ?>
                    <span class="number_item_cart"><?php echo $count; ?></span>
                </a>

                <!-- Mobile Menu Button -->
                <button class="hamburger" id="hamburger">
                    <img src="images/bars-solid.svg" alt="Menu">
                </button>
            </div>
        </div>
    </div>

    <!-- Include Menu inside header for fixed positioning -->
    <?php include("menu.php"); ?>
</div>

<!-- Scroll Effect Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Force logo to be visible
    const logo = document.querySelector('.logo');
    const logoImg = document.querySelector('.logo img');
    
    if (logo) {
        logo.style.cssText = 'display: flex !important; visibility: visible !important; opacity: 1 !important; height: 100%; align-items: center;';
        console.log('Logo container found and forced visible');
    } else {
        console.error('Logo container not found!');
    }
    
    if (logoImg) {
        logoImg.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; height: 70px !important; width: auto !important; max-width: 200px; object-fit: contain;';
        console.log('Logo image found:', logoImg.src);
        console.log('Logo image dimensions:', logoImg.offsetWidth, 'x', logoImg.offsetHeight);
        
        // Check if image loaded
        if (logoImg.complete) {
            console.log('Logo image loaded successfully');
        } else {
            logoImg.addEventListener('load', function() {
                console.log('Logo image loaded');
            });
            logoImg.addEventListener('error', function() {
                console.error('Logo image failed to load:', logoImg.src);
            });
        }
    } else {
        console.error('Logo image not found!');
    }
    
    const header = document.getElementById('mainHeader');
    let lastScroll = 0;
    
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });

    // Hover effect cho user dropdown - Enhanced version
    const userMenu = document.querySelector('.hotline.logout');
    if (userMenu) {
        const dropdown = userMenu.querySelector('.logout_content');
        
        console.log('User menu found:', userMenu);
        console.log('Dropdown found:', dropdown);
        
        if (dropdown) {
            // Force initial state
            dropdown.style.cssText = `
                position: absolute !important;
                display: block !important;
                opacity: 0 !important;
                visibility: hidden !important;
                transform: translateY(-15px) !important;
                pointer-events: none !important;
                z-index: 10000 !important;
            `;
            
            userMenu.addEventListener('mouseenter', function() {
                console.log('Mouse entered user menu');
                dropdown.style.opacity = '1';
                dropdown.style.visibility = 'visible';
                dropdown.style.transform = 'translateY(0)';
                dropdown.style.pointerEvents = 'auto';
            });
            
            userMenu.addEventListener('mouseleave', function() {
                console.log('Mouse left user menu');
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateY(-15px)';
                dropdown.style.pointerEvents = 'none';
            });
            
            // Keep dropdown open when hovering over it
            dropdown.addEventListener('mouseenter', function() {
                console.log('Mouse entered dropdown');
                dropdown.style.opacity = '1';
                dropdown.style.visibility = 'visible';
                dropdown.style.transform = 'translateY(0)';
                dropdown.style.pointerEvents = 'auto';
            });
            
            dropdown.addEventListener('mouseleave', function() {
                console.log('Mouse left dropdown');
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateY(-15px)';
                dropdown.style.pointerEvents = 'none';
            });
        } else {
            console.error('Dropdown not found!');
        }
    } else {
        console.log('User menu not found - user may not be logged in');
    }
});
</script>
