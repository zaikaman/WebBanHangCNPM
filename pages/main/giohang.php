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
                    <div class="card card-registration card-registration-2" style="border-radius: 15px; padding : 0">
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
                                                    <hr class="my-4" style="border-width: 2px;">
                                                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                                            <img src="admincp/modules/quanLySanPham/uploads/<?php echo $cart_item['hinh_anh']; ?>" class="img-fluid rounded-3" alt="Product Image">
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3" style="padding: 0;">
                                                            <h6 class="text-muted"><?php echo $cart_item['ten_sp']; ?></h6>
                                                            <h6 class="mb-0"><?php echo $cart_item['ten_sp']; ?></h6>
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                            <span style="font-size: 20px; font-weight : bold; margin-right : 7px ">
                                                                <a style="color : red;" href="pages/main/themgiohang.php?tru=<?php echo $cart_item['id'] ?>">-</a>
                                                            </span>
                                                            <input style="width : 60%" min="0" name="quantity" value="<?php echo $cart_item['so_luong']; ?>" type="number" class="form-control form-control-sm" disabled />
                                                            <span style="font-size: 20px; font-weight : bold; margin-left : 4px ">
                                                                <a style="color : red;" href="pages/main/themgiohang.php?cong=<?php echo $cart_item['id'] ?>">+</a> </span>
                                                        </div>
                                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1" style="padding: 0;">
                                                            <h6 class="mb-0"><?php echo number_format($cart_item['gia_sp'], 0, ',', ',') . 'đ'; ?></h6>
                                                        </div>
                                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end" style="padding: 0;">
                                                            <a href="pages/main/themgiohang.php?xoa=<?php echo $cart_item['id']; ?>" class="text-muted"><ion-icon name="close-circle-outline" style="font-size : 22px; color:red"></ion-icon></a>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if ($count == 0) {
                                            ?>
                         
                                                <hr class="my-4" style="border-width: 2px;">
                                                <div style="width : 100%; display : flex; flex-direction : column; align-items : center; justify-content : center">
                                                    <img style="margin-top: 0px;" src="images/emptycart.jpg" alt="EmtpyCart" width="200px" height="200px">
                                                    <h4 style="font-style: italic; margin : 0 0 20px 0;">Giỏ hàng trống </h4>
                                                </div>
                                            <?php } ?>
                                            <div style=" display : flex; margin-top : 20px;">
                                                <a href="index.php" class="dathang_button">
                                                    Trở về trang chủ
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 bg-body-tertiary" style="border-radius: 15px;">
                                        <div class="p-5">
                                            <h3 class="fw-bold mb-5 mt-2 pt-1">Thanh toán</h3>
                                            <hr class="my-4" style="border-width : 2px">
                                            <div class="d-flex justify-content-between mb-4">
                                                <h5>Số lượng sản phẩm : <?php echo $tongsoluong; ?></h5>
                                                <!-- <h5><?php echo number_format($tongtien, 0, ',', ',') . 'đ'; ?></h5> -->
                                            </div>

                                            <!-- <h5 class="text-uppercase mb-3">Shipping</h5>
                                            <div class="mb-4 pb-2">
                                                <select class="form-select">
                                                    <option value="1">Standard-Delivery- 5.00€</option>
                                                    <option value="2">Express Delivery</option>
                                                </select>
                                            </div>

                                            <h5 class="text-uppercase mb-3">Give code</h5>
                                            <div class="mb-5">
                                                <input type="text" id="form3Examplea2" class="form-control form-control-lg" placeholder="Enter your code">
                                            </div> -->

                                            <hr class="my-4" style="border-width : 2px">

                                            <div class="d-flex justify-content-between mb-5">
                                                <h5>Thành tiền :</h5>
                                                <h5><?php echo number_format($tongtien, 0, ',', ',') . 'đ'; // Assuming 5€ shipping 
                                                    ?></h5>
                                            </div>
                                            <?php
                                            if ($count != 0) {
                                                if (isset($_SESSION['dang_ky']) && isset($_SESSION['id_khachhang'])) {
                                            ?>
                                                    <a href="index.php?quanly=vanChuyen" class="dathang_button" style="font-size: 16px;">
                                                        Tiếp theo
                                                    </a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a href="index.php?quanly=dangnhap" class="dathang_button" style="font-size: 16px;">
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

<style>
    @media (min-width: 1025px) {
        .h-custom {
            height: 100vh !important;
        }
    }

    .card-registration .select-input.form-control[readonly]:not([disabled]) {
        font-size: 1rem;
        line-height: 2.15;
        padding-left: .75em;
        padding-right: .75em;
    }

    .card-registration .select-arrow {
        top: 13px;
    }
</style>
