<link rel="stylesheet" type="text/css" href="css/giohang.css?v=<?php echo time(); ?>">
<div class="main_content">
    <div class="cart_content">
        <?php
        if (isset($_SESSION['dang_ky']) && isset($_SESSION['id_khachhang'])) { ?>
            <div class="wrapper-2">
                <div class="arrow-steps clearfix">
                    <div class="step current"> <span> <a href="index.php?quanly=giohang"> Giỏ hàng</a></span> </div>
                    <div class="step"> <span><a href="index.php?quanly=vanChuyen"> Vận chuyển</a></span> </div>
                    <div class="step"> <span><a href="index.php?quanly=thongTinThanhToan">Thanh toán</a></span> </div>
                    <div class="step"> <span><a href="index.php?quanly=lichSuDonHang">Lịch sử</a></span> </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="wrapper-2">
                <div class="arrow-steps clearfix">
                    <div class="step current"> <span> <a href="index.php?quanly=giohang&user_notfound=1"> Giỏ hàng</a></span> </div>
                    <div class="step"> <span><a href="index.php?quanly=giohang&user_notfound=1"> Vận chuyển</a></span> </div>
                    <div class="step"> <span><a href="index.php?quanly=giohang&user_notfound=1">Thanh toán</a></span> </div>
                    <div class="step"> <span><a href="index.php?quanly=giohang&user_notfound=1">Lịch sử</a></span> </div>
                </div>
            </div>
        <?php } ?>
        <!-- GIO HANG -->
        <?php
        $items_number = 0;
        $tongsoluong = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cart_item) {
                $items_number++;
                $tongsoluong += $cart_item['so_luong'];
            }
        } ?>
        <section class="h-100 w-100">
            <div class="container py-4 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="card card-registration card-registration-2 card-cart-custom">
                        <div class="col-12">
                            <div class="card-body p-0">
                                <div class="row g-0 d-flex justify-content-between">
                                    <div class="col-lg-8 ">
                                        <div class="p-5">

                                            <div class="d-flex justify-content-between align-items-center mb-5">
                                                <h1 class="fw-bold mb-0">Giỏ hàng</h1>
                                                <h6 class="mb-0 text-muted"><?php echo $items_number . ' mặt hàng'; ?></h6>
                                            </div>
                                            <?php
                                            $count = 0;
                                            $tongtien = 0;
                                            if (isset($_SESSION['cart'])) {
                                                foreach ($_SESSION['cart'] as $cart_item) {
                                                    $count++;
                                                    $thanhtien = $cart_item['gia_sp'] * $cart_item['so_luong'];
                                                    $tongtien += $thanhtien;
                                            ?>
                                                    <hr class="my-4 hr-bold">
                                                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                                            <img src="admincp/modules/quanLySanPham/uploads/<?php echo $cart_item['hinh_anh']; ?>" class="img-fluid rounded-3" alt="Product Image">
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3 p-0">
                                                            <h6 class="text-muted"><?php echo $cart_item['ten_sp']; ?></h6>
                                                            <h6 class="mb-0"><?php echo $cart_item['ten_sp']; ?></h6>
                                                            <div class="size-selector">
                                                                <small class="text-muted">Size: </small>
                                                                <select class="size-select form-select form-select-sm d-inline-block size-select-inline" 
                                                                        data-id="<?php echo $cart_item['id']; ?>" 
                                                                        data-current-size="<?php echo isset($cart_item['size']) ? $cart_item['size'] : 'M'; ?>">
                                                                    <option value="S" <?php echo (isset($cart_item['size']) && $cart_item['size'] == 'S') ? 'selected' : ''; ?>>S</option>
                                                                    <option value="M" <?php echo (!isset($cart_item['size']) || $cart_item['size'] == 'M') ? 'selected' : ''; ?>>M</option>
                                                                    <option value="L" <?php echo (isset($cart_item['size']) && $cart_item['size'] == 'L') ? 'selected' : ''; ?>>L</option>
                                                                    <option value="XL" <?php echo (isset($cart_item['size']) && $cart_item['size'] == 'XL') ? 'selected' : ''; ?>>XL</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-2">
                                                            <div class="quantity-controls d-flex align-items-center justify-content-center">
                                                                <button class="quantity-btn decrease-btn" 
                                                                        data-action="decrease" 
                                                                        data-id="<?php echo $cart_item['id']; ?>" 
                                                                        data-size="<?php echo isset($cart_item['size']) ? $cart_item['size'] : 'M'; ?>">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input class="quantity-input" 
                                                                       min="1" 
                                                                       name="quantity" 
                                                                       value="<?php echo $cart_item['so_luong']; ?>" 
                                                                       type="number" 
                                                                       data-id="<?php echo $cart_item['id']; ?>" 
                                                                       data-size="<?php echo isset($cart_item['size']) ? $cart_item['size'] : 'M'; ?>" />
                                                                <button class="quantity-btn increase-btn" 
                                                                        data-action="increase" 
                                                                        data-id="<?php echo $cart_item['id']; ?>" 
                                                                        data-size="<?php echo isset($cart_item['size']) ? $cart_item['size'] : 'M'; ?>">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1 p-0">
                                                            <h6 class="mb-0"><?php echo number_format($cart_item['gia_sp'], 0, ',', ',') . 'đ'; ?></h6>
                                                        </div>
                                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end p-0">
                                                            <button class="btn btn-link text-muted remove-btn btn-remove-item" 
                                                                    data-id="<?php echo $cart_item['id']; ?>" 
                                                                    data-size="<?php echo isset($cart_item['size']) ? $cart_item['size'] : 'M'; ?>">
                                                                <ion-icon name="close-circle-outline" class="icon-danger"></ion-icon>
                                                            </button>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if ($count == 0) {
                                            ?>
                         
                                                <hr class="my-4 hr-bold">
                                                <div class="empty-cart-container">
                                                    <img class="mt-0" src="images/emptycart.jpg" alt="EmtpyCart" width="200px" height="200px">
                                                    <h4 class="empty-cart-text">Giỏ hàng trống </h4>
                                                </div>
                                            <?php } ?>
                                            <div class="back-home-container">
                                                <a href="index.php" class="dathang_button">
                                                    Trở về trang chủ
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 bg-body-tertiary summary-panel-custom">
                                        <div class="p-5">
                                            <h3 class="fw-bold mb-5 mt-2 pt-1">Thanh toán</h3>
                                            <hr class="my-4 hr-bold">
                                            <div class="d-flex justify-content-between mb-4">
                                                <h5>Số lượng sản phẩm : <?php echo $tongsoluong; ?></h5>
                                            </div>

                                            <hr class="my-4 hr-bold">

                                            <div class="d-flex justify-content-between mb-5">
                                                <h5>Thành tiền :</h5>
                                                <h5><?php echo number_format($tongtien, 0, ',', ',') . 'đ'; // Assuming 5€ shipping 
                                                    ?></h5>
                                            </div>
                                            <?php
                                            if ($count != 0) {
                                                if (isset($_SESSION['dang_ky']) && isset($_SESSION['id_khachhang'])) {
                                            ?>
                                                    <a href="index.php?quanly=vanChuyen" class="dathang_button">
                                                        Tiếp theo
                                                    </a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a href="index.php?quanly=dangnhap" class="dathang_button">
                                                        Đăng nhập để mua hàng
                                                    </a>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="js/giohang.js" defer></script>
