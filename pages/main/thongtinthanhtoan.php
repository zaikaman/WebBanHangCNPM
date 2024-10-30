<div class="main_content">
    <div class="cart_content">
        <div class="wrapper-2">
            <div class="arrow-steps clearfix">
                <div class="step done"> <span> <a href="index.php?quanly=giohang"> Giỏ hàng</a></span> </div>
                <div class="step done"> <span><a href="index.php?quanly=vanChuyen"> Vận chuyển</a></span> </div>
                <div class="step current"> <span><a href="index.php?quanly=thongTinThanhToan">Thanh toán</a></span> </div>
                <div class="step "> <span><a href="index.php?quanly=lichSuDonHang">Lịch sử</a></span> </div>
            </div>
        </div>
        <form action="pages/main/thanhtoan.php" method="POST" enctype="application/x-www-form-urlencoded" style="margin-top : 0px; width: 100%;">
            <div class="row">
                <?php
                $id_dangky = $_SESSION['id_khachhang'];
                $sql_get_vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_giaohang WHERE id_dangky='$id_dangky' LIMIT 1");
                $count = mysqli_num_rows($sql_get_vanchuyen);
                if ($count > 0) {
                    $row_get_vanchuyen = mysqli_fetch_array($sql_get_vanchuyen);
                    $name = $row_get_vanchuyen['name'];
                    $phone = $row_get_vanchuyen['phone'];
                    $address = $row_get_vanchuyen['address'];
                    $note = $row_get_vanchuyen['note'];
                } else {
                    $name = '';
                    $phone = '';
                    $address = '';
                    $note = '';
                }
                ?>
                <?php
                $items_number = 0;
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $cart_item) {
                        $items_number++;
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
                                                <div class="p-5 ">
                                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                                        <h1 class="fw-bold mb-0 giohang">Thanh toán</h1>
                                                        <h6 class="mb-0 text-muted"><?php echo $items_number . ' sản phẩm'; ?></h6>
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
                                                                <div class="col-md-2 col-lg-2 col-xl-2 c-img">
                                                                    <img src="/admincp/modules/quanLySanPham/uploads/<?php echo $cart_item['hinh_anh']; ?>" class="img-fluid rounded-3" alt="Product Image">
                                                                </div>
                                                                <div class="col-md-3 col-lg-3 col-xl-3 c-info" style="padding: 0;">
                                                                    <h6 class="text-muted"><?php echo $cart_item['ten_sp']; ?></h6>
                                                                    <h6 class="mb-0"><?php echo $cart_item['ten_sp']; ?></h6>
                                                                </div>
                                                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex c-quantity">
                                                                    <input style="width : 60%" min="0" name="quantity" value="<?php echo $cart_item['so_luong']; ?>" type="number" class="form-control form-control-sm" disabled />
                                                                </div>
                                                                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1 c-price" style="padding: 0;">
                                                                    <h6 class="mb-0"><?php echo number_format($cart_item['gia_sp'], 0, ',', ',') . 'đ'; ?></h6>
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
                                                            <img style="margin-top: 0px;" src="../images/emptycart.jpg" alt="EmtpyCart" width="200px" height="200px">
                                                            <h4 style="font-style: italic; margin : 0 0 20px 0;">Giỏ hàng trống </h4>
                                                        </div>
                                                    <?php } ?>
                                                    <div style=" display : flex; margin-top : 20px;">
                                                        <a href="index.php?quanly=giohang" class="dathang_button">
                                                            Trở về giỏ hàng
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- PHUONG THUC THANH TOAN -->
                                            <div class="col-lg-4 bg-body-tertiary" style="border-radius: 15px;">
                                                <div class="p-5">
                                                    <h5 class="fw-bold mb-5 mt-2 pt-1">Phương thức thanh toán</h5>
                                                    <hr class="my-4" style="border-width : 2px">
                                                    <div class="d-flex justify-content-between mb-4">
                                                        <h5>Thành tiền :</h5>
                                                        <h5><?php echo number_format($tongtien, 0, ',', ',') . 'đ'; // Assuming 5€ shipping 
                                                            ?></h5>
                                                    </div>
                                                    <hr class="my-4" style="border-width : 2px">
                                                    <div class="d-flex justify-content-between mb-5">
                                                        <div style="display : flex; justify-content : center; align-items : start; flex-direction : column; width : 100%
                                                        ; gap : 10px">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="payment" value="tienmat" id="radios1" checked>
                                                                <img style="width: 32px; height:32px" src="../../images/cash.jpg">
                                                                <label class="form-check-label" for="radios1">
                                                                    Tiền mặt
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="payment" value="chuyenkhoan" id="radios2">
                                                                <img style="width: 32px; height:32px" src="images/banking.png">
                                                                <label class="form-check-label" for="radios2">
                                                                    Chuyển khoản
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="payment" value="vnpay" id="radios4">
                                                                <img style="width: 32px; height:32px" src="images/vnpay.png">
                                                                <label class="form-check-label" for="radios4">
                                                                    VNPay
                                                                </label>
                                                            </div>
                                                            <?php
                                                            if ($count != 0) {

                                                            ?>
                                                                <form></form>
                                                                <button type="submit" value="Đặt hàng" name="thanhToan" style="width : 100%; padding : 20px 0 20px 0" class="purchase_button">Đặt hàng</button>
                                                                <div style="width : 100%; display : flex; justify-content : center; align-items : center"><h4>Hoặc</h4></div>
                                                                <form method="POST" target="_blank" enctype="application/x-www-form-urlencoded" action="pages/main/xuLyThanhToanMomo.php" style="margin-bottom:5px;width: 100%">
                                                                    <button type="submit" name="momo" value="Thanh toán MOMO QRCode"style="width : 100%; padding : 20px 0 20px 0" class="purchase_button momo"> MoMo QRCode</button>
                                                                </form>
                                                                <form class="" method="POST" target="_blank" enctype="application/x-www-form-urlencoded"
                                                                    action="pages/main/xuLyThanhToanMomo_atm.php" style="width: 100%">
                                                                    <button type="submit" name="momo" value="Thanh toán MOMO ATM"style="width : 100%; padding : 20px 0 20px 0" class="purchase_button momo"> MoMo ATM</button>
                                                                </form>
                                                            <?php
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
                        </div>
                    </div>
                </section>
            </div>
        </form>
    </div>
</div>


<!-- THANH TOAN MOMO -->
<!-- <div class="col-md-4" style="float:left;margin-left:10px;">
                    <h5 style="text-align:center"> PHƯƠNG THỨC THANH TOÁN</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" value="tienmat" id="radios1" checked>
                        <img style="width: 32px; height:32px" src="../../">
                        <label class="form-check-label" for="radios1">
                            Tiền mặt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" value="chuyenkhoan" id="radios2">
                        <img style="width: 32px; height:32px" src="images/banking.png">
                        <label class="form-check-label" for="radios2">
                            Chuyển khoản
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" value="vnpay" id="radios4">
                        <img style="width: 32px; height:32px" src="images/vnpay.png">
                        <label class="form-check-label" for="radios4">
                            VNPay
                        </label>
                    </div>
                    <?php if ($items_number > 0) { ?>
                        <form></form>
                        <button type="submit" value="Đặt hàng" name="thanhToan" class="purchase_button">Đặt hàng</button>
                        <h4>Hoặc</h4>
                        <form method="POST" target="_blank" enctype="application/x-www-form-urlencoded" action="pages/main/xuLyThanhToanMomo.php" style="margin-bottom:5px;width: 500px">
                            <button type="submit" name="momo" value="Thanh toán MOMO QRCode" class="purchase_button momo">Thanh toán MOMO QRCode</button>
                        </form>

                        <form class="" method="POST" target="_blank" enctype="application/x-www-form-urlencoded"
                            action="pages/main/xuLyThanhToanMomo_atm.php" style="margin-bottom:5px">
                            <button type="submit" name="momo" value="Thanh toán MOMO ATM" class="purchase_button momo">Thanh toán MOMO ATM</button>
                        </form>
                    <?php } else { ?>
                        <a href="index.php" class="dathang_button">
                            Mua sắm
                        </a>
                    <?php } ?>
                </div> -->