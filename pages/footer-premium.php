<footer class="premium-footer">
    <!-- Newsletter Section - Integrated into Footer -->
    <div class="footer-newsletter">
        <div class="newsletter-container">
            <div class="newsletter-content">
                <h2 class="newsletter-title">Đăng Ký Nhận Tin</h2>
                <p class="newsletter-description">
                    Nhận thông tin về sản phẩm mới, ưu đãi độc quyền và các bí quyết phong cách thể thao qua email
                </p>
            </div>
            <form class="newsletter-form-premium" method="POST" action="#">
                <div class="input-group">
                    <input type="email" 
                           class="newsletter-input-premium" 
                           placeholder="Email của bạn"
                           required>
                    <button type="submit" class="newsletter-btn-premium">
                        <span>Đăng Ký</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Footer Content -->
    <div class="footer-main">
        <div class="footer-container">
            <!-- Company Info -->
            <div class="footer-column footer-brand">
                <img src="images/logo.png" alt="7TCC Logo" class="footer-logo">
                <p class="footer-tagline">For True Fans Since 2024</p>
                <p class="footer-description">
                    Chuyên cung cấp trang phục thể thao chính hãng, chất lượng cao với giá cả hợp lý.
                    Đồng hành cùng đam mê thể thao của bạn.
                </p>
                
                <!-- Social Media -->
                <div class="footer-social">
                    <a href="#" class="social-link" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-column">
                <h3 class="footer-title">Về 7TCC</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="index.php?quanly=gioithieu">Giới thiệu</a></li>
                    <li><a href="index.php?quanly=tintuc">Tin tức</a></li>
                    <li><a href="index.php?quanly=lienhe">Liên hệ</a></li>
                    <li><a href="index.php?quanly=tuyendung">Tuyển dụng</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="footer-column">
                <h3 class="footer-title">Danh Mục</h3>
                <ul class="footer-links">
                    <?php
                    $sql_danhmucsanpham = "SELECT * FROM tbl_danhmucqa ORDER BY id_dm DESC LIMIT 6";
                    $query_danhmuc = mysqli_query($mysqli, $sql_danhmucsanpham);
                    while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
                    ?>
                        <li>
                            <a href="index.php?quanly=danhmucsanpham&id=<?php echo $row_danhmuc['id_dm'] ?>">
                                <?php echo $row_danhmuc['name_sp'] ?>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>

            <!-- Customer Support -->
            <div class="footer-column">
                <h3 class="footer-title">Hỗ Trợ Khách Hàng</h3>
                <ul class="footer-links">
                    <li><a href="index.php?quanly=CSQDC">Chính sách chung</a></li>
                    <li><a href="index.php?quanly=QDHTTT">Phương thức thanh toán</a></li>
                    <li><a href="index.php?quanly=CSVC">Vận chuyển & Giao nhận</a></li>
                    <li><a href="index.php?quanly=CSBH">Chính sách bảo hành</a></li>
                    <li><a href="index.php?quanly=CSDT">Đổi trả sản phẩm</a></li>
                    <li><a href="index.php?quanly=CSBM">Chính sách bảo mật</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-column">
                <h3 class="footer-title">Liên Hệ</h3>
                <ul class="footer-contact">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Hóc Môn, TP. Hồ Chí Minh</span>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <span>1900 8888</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>support@7tcc.vn</span>
                    </li>
                    <li>
                        <i class="fas fa-clock"></i>
                        <span>8:00 - 22:00 (Hàng ngày)</span>
                    </li>
                </ul>

                <!-- Payment Methods -->
                <div class="footer-payments">
                    <h4 class="payment-title">Thanh toán</h4>
                    <div class="payment-icons">
                        <img src="images/visa.png" alt="Visa" title="Visa">
                        <img src="images/atm.png" alt="ATM" title="ATM/Debit">
                        <img src="images/jcb.png" alt="JCB" title="JCB">
                        <img src="images/debit.png" alt="MasterCard" title="MasterCard">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="footer-container">
            <p class="copyright">
                © 2024 7TCC. All rights reserved. | Designed with 
                <i class="fas fa-heart"></i> for True Fans
            </p>
            <div class="footer-bottom-links">
                <a href="index.php?quanly=CSBM">Chính sách bảo mật</a>
                <span class="separator">|</span>
                <a href="index.php?quanly=CSQDC">Điều khoản sử dụng</a>
                <span class="separator">|</span>
                <a href="#">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
