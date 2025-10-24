<?php $sql_lietke = "SELECT * FROM tbl_danhmucqa ORDER BY id_dm DESC ";
$lietke = mysqli_query($mysqli, $sql_lietke);
?>

<!-- Premium Menu CSS -->
<link rel="stylesheet" href="css/menu-premium.css?v=<?php echo time(); ?>">

<!-- Drawer Overlay -->
<div class="drawer-overlay" id="drawer-overlay"></div>

<div class="menu">
    <div class="menu_content">
        <div class="menu_items">
            <a class="item" href="index.php" data-ajax="true">Trang chủ<span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
        </div>
        <?php
        while ($row_danhmuc = mysqli_fetch_array($lietke)) {
        ?>
            <div class="menu_items">
                <a class="item" href="index.php?quanly=danhmucsanpham&id=<?php echo $row_danhmuc['id_dm'] ?>" data-ajax="true"><?php echo $row_danhmuc['name_sp'] ?><span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
            </div>
        <?php } ?>

        <div class="menu_items">
            <a class="item" href="index.php?quanly=giohang" data-ajax="true">Giỏ hàng<span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
        </div>

        <?php if (isset($_SESSION['dang_ky'])): ?>
        <div class="menu_items">
            <a class="item" href="index.php?quanly=lichSuDonHang" data-ajax="true">Lịch sử đơn hàng<span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
        </div>
        <?php endif; ?>

        <div class="menu_items">
            <a class="item" href="index.php?quanly=tintuc" data-ajax="true">Tin tức<span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
            <div class="news_content" id="news_content">
                <?php
                // Lấy danh mục bài viết
                $sql_danhmuc = "SELECT * FROM tbl_danhmuc_baiviet ORDER BY id_baiviet DESC";
                $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
                while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
                ?>
                    <!-- <li style="text-decoration:none"> -->
                    <a href="index.php?quanly=danhmucbaiviet&id_baiviet=<?php echo $row_danhmuc['id_baiviet']; ?>" data-ajax="true">
                        <span style="text-transform: uppercase;"><?php echo $row_danhmuc['tendanhmuc_baiviet']; ?></span>
                    </a>
                    <!-- </li> -->
                <?php
                }
                ?>
            </div>
        </div>


        <div class="menu_items">
            <a class="item" href="index.php?quanly=lienhe" data-ajax="true">Liên hệ<span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
        </div>

        <div class="hamburger" id="hamburger">
            <img src="images/bars-solid.svg" alt="" width="30px" height="30px">
        </div>
        <!-- Ngăn kéo (Drawer) -->
        <div class="drawer" id="drawer">
            <button class="close-btn" id="close-btn">
                Menu
                <span>&times;</span>
            </button>
            <ul style="margin-top: 0; padding-left: 0">
                <li>
                    <div class="search_container_menubar">
                        <form class="search_form" action="index.php?quanly=timKiem" method="POST" data-ajax="true">
                            <input class="search_input" type="text" name="tuKhoa" id="search-box" placeholder="...">
                            <button class="search_btn" type="submit" name="timKiem" class="icon_container">
                                <img src="images/search-icon.svg" alt="arrow">
                            </button>
                        </form>
                    </div>
                </li>
                <li> <a class="item" href="index.php" data-ajax="true">Trang chủ<span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
                </li>
                <?php
                while ($row_danhmuc = mysqli_fetch_array($lietke)) {
                ?>

                    <li>
                        <a class="item" href="index.php?quanly=danhmucsanpham&id=<?php echo $row_danhmuc['id_dm'] ?>" data-ajax="true"><?php echo $row_danhmuc['name_sp'] ?><span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
                    </li>
                <?php } ?>
                <li> <a class="item" href="index.php?quanly=giohang" data-ajax="true">Giỏ hàng<span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
                </li>
                
                <?php if (isset($_SESSION['dang_ky'])): ?>
                <li> <a class="item" href="index.php?quanly=lichSuDonHang" data-ajax="true">Lịch sử đơn hàng<span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
                </li>
                <?php endif; ?>

                <li style="position : relative">
                    <a class="item" href="index.php?quanly=tintuc" id="newsMenuItem" data-ajax="true">Shop<span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
                    <div class="news_content_burger" id="news_content_burger" style="display: none;">
                        <?php
                        // Lấy danh mục bài viết
                        $sql_danhmucsanpham = "SELECT * FROM tbl_danhmucqa ORDER BY id_dm DESC";
                        $query_danhmuc = mysqli_query($mysqli, $sql_danhmucsanpham);
                        while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
                        ?>
                            <a href="index.php?quanly=danhmucsanpham&id=<?php echo $row_danhmuc['id_dm']; ?>" data-ajax="true">
                                <span style="text-transform: uppercase;"><?php echo $row_danhmuc['name_sp']; ?></span>
                            </a><br>
                        <?php
                        }
                        ?>
                    </div>
                </li>

                <li style="position : relative">
                    <a class="item" href="index.php?quanly=tintuc" id="newsMenuItem1" data-ajax="true">Tin tức<span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a>
                    <div class="news_content_burger" id="news_content_burger1" style="display: none;">
                        <?php
                        // Lấy danh mục bài viết
                        $sql_danhmuc = "SELECT * FROM tbl_danhmuc_baiviet ORDER BY id_baiviet DESC";
                        $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
                        while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
                        ?>
                            <a href="index.php?quanly=danhmucbaiviet&id_baiviet=<?php echo $row_danhmuc['id_baiviet']; ?>" data-ajax="true">
                                <span style="text-transform: uppercase;"><?php echo $row_danhmuc['tendanhmuc_baiviet']; ?></span>
                            </a><br>
                        <?php
                        }
                        ?>
                    </div>
                </li>
                
                <li><a class="item" href="index.php?quanly=lienhe" data-ajax="true">Liên hệ<span class="arrow_menu"><img src="images/arrow-icon.svg" alt="arrow"></span></a></li>
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger');
    const drawer = document.getElementById('drawer');
    const drawerOverlay = document.getElementById('drawer-overlay');
    const closeBtn = document.getElementById('close-btn');
    const newsMenuItem = document.getElementById('newsMenuItem');
    const newsContentBurger = document.getElementById('news_content_burger');
    const newsMenuItem1 = document.getElementById('newsMenuItem1');
    const newsContentBurger1 = document.getElementById('news_content_burger1');

    // Toggle drawer function
    function toggleDrawer(show) {
        if (show) {
            drawer.classList.add('active');
            drawerOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        } else {
            drawer.classList.remove('active');
            drawerOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Open drawer
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            toggleDrawer(true);
        });
    }

    // Close drawer
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            toggleDrawer(false);
        });
    }

    // Close drawer when clicking overlay
    if (drawerOverlay) {
        drawerOverlay.addEventListener('click', function() {
            toggleDrawer(false);
        });
    }

    // Close drawer on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            toggleDrawer(false);
        }
    });

    // Toggle submenu in drawer
    if (newsMenuItem) {
        newsMenuItem.addEventListener('click', function(e) {
            e.preventDefault();
            newsContentBurger.classList.toggle('active');
        });
    }

    if (newsMenuItem1) {
        newsMenuItem1.addEventListener('click', function(e) {
            e.preventDefault();
            newsContentBurger1.classList.toggle('active');
        });
    }
});
</script>

<style>
</style>
