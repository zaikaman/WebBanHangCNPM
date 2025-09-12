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
                                                            <div class="size-selector">
                                                                <small class="text-muted">Size: </small>
                                                                <select class="size-select form-select form-select-sm d-inline-block" 
                                                                        style="width: auto; display: inline-block;" 
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
                                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1" style="padding: 0;">
                                                            <h6 class="mb-0"><?php echo number_format($cart_item['gia_sp'], 0, ',', ',') . 'đ'; ?></h6>
                                                        </div>
                                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end" style="padding: 0;">
                                                            <button class="btn btn-link text-muted remove-btn" 
                                                                    data-id="<?php echo $cart_item['id']; ?>" 
                                                                    data-size="<?php echo isset($cart_item['size']) ? $cart_item['size'] : 'M'; ?>"
                                                                    style="padding: 0; border: none; background: none;">
                                                                <ion-icon name="close-circle-outline" style="font-size: 22px; color: red;"></ion-icon>
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

    .size-selector {
        margin-top: 5px;
    }

    /* Enhanced Quantity Controls */
    .quantity-controls {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 2px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        width: fit-content;
    }

    .quantity-controls:hover {
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        border-color: #dc3545;
    }

    .quantity-btn {
        background: #fff;
        border: 1px solid #e9ecef;
        color: #dc3545;
        width: 28px;
        height: 28px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 11px;
        padding: 0;
        flex-shrink: 0;
    }

    .quantity-btn:hover {
        background: #dc3545;
        color: white;
        border-color: #dc3545;
        transform: translateY(-1px);
        box-shadow: 0 1px 3px rgba(220, 53, 69, 0.3);
    }

    .quantity-btn:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(220, 53, 69, 0.3);
    }

    .quantity-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .quantity-btn:disabled:hover {
        background: #fff;
        color: #dc3545;
        border-color: #e9ecef;
    }

    .quantity-input {
        width: 35px;
        height: 28px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 600;
        font-size: 14px;
        color: #495057;
        margin: 0 3px;
        padding: 0;
        outline: none;
        flex-shrink: 0;
    }

    .quantity-input:focus {
        outline: none;
        box-shadow: none;
        background: rgba(220, 53, 69, 0.1);
        border-radius: 3px;
    }

    /* Remove number input arrows */
    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        appearance: none;
        margin: 0;
    }

    .quantity-input[type=number] {
        -moz-appearance: textfield;
        appearance: textfield;
    }

    /* Animation for loading state */
    .quantity-controls.loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .quantity-controls.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 16px;
        height: 16px;
        margin: -8px 0 0 -8px;
        border: 2px solid #dc3545;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .quantity-controls {
            padding: 2px;
        }
        
        .quantity-btn {
            width: 28px;
            height: 28px;
            font-size: 11px;
        }
        
        .quantity-input {
            width: 40px;
            height: 28px;
            font-size: 13px;
            margin: 0 4px;
        }
    }

    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hàm hiển thị thông báo
    function showMessage(message, type = 'info') {
        // Tạo element thông báo
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.style.minWidth = '300px';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Tự động ẩn sau 3 giây
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }

    // Hàm gửi AJAX request
    function sendAjaxRequest(data, callback) {
        fetch('pages/main/ajax_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(data)
        })
        .then(response => response.json())
        .then(result => {
            if (callback) callback(result);
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Có lỗi xảy ra, vui lòng thử lại', 'error');
        });
    }

    // Hàm cập nhật tổng tiền và số lượng
    function updateCartTotals() {
        let totalQuantity = 0;
        let totalPrice = 0;
        
        document.querySelectorAll('.quantity-input').forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const priceElement = input.closest('.row').querySelector('.col-md-3.col-lg-2.col-xl-2 h6');
            if (priceElement) {
                const priceText = priceElement.textContent.replace(/[^\d]/g, '');
                const price = parseInt(priceText) || 0;
                totalQuantity += quantity;
                totalPrice += (price * quantity);
            }
        });
        
        // Cập nhật số lượng sản phẩm
        const quantityElement = document.querySelector('.d-flex.justify-content-between.mb-4 h5');
        if (quantityElement) {
            quantityElement.textContent = `Số lượng sản phẩm : ${totalQuantity}`;
        }
        
        // Cập nhật thành tiền
        const totalElement = document.querySelector('.d-flex.justify-content-between.mb-5 h5:last-child');
        if (totalElement) {
            totalElement.textContent = new Intl.NumberFormat('vi-VN').format(totalPrice) + 'đ';
        }
        
        // Cập nhật số mặt hàng ở header
        const itemCountElement = document.querySelector('.mb-0.text-muted');
        if (itemCountElement) {
            const itemCount = document.querySelectorAll('.quantity-input').length;
            itemCountElement.textContent = `${itemCount} mặt hàng`;
        }
    }

    // Xử lý thay đổi size
    document.querySelectorAll('.size-select').forEach(select => {
        select.addEventListener('change', function() {
            const id = this.dataset.id;
            const currentSize = this.dataset.currentSize;
            const newSize = this.value;
            
            if (currentSize === newSize) return;
            
            this.disabled = true;
            
            sendAjaxRequest({
                action: 'update_size',
                id: id,
                size: currentSize,
                new_size: newSize
            }, (result) => {
                if (result.success) {
                    showMessage(result.message, 'success');
                    // Cập nhật dataset cho các thao tác tiếp theo
                    this.dataset.currentSize = newSize;
                    const quantityControls = this.closest('.row').querySelectorAll('[data-size]');
                    quantityControls.forEach(control => {
                        control.dataset.size = newSize;
                    });
                } else {
                    showMessage(result.message, 'error');
                    // Khôi phục giá trị cũ
                    this.value = currentSize;
                }
                this.disabled = false;
            });
        });
    });

    // Xử lý thay đổi số lượng bằng input
    document.querySelectorAll('.quantity-input').forEach(input => {
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            const id = this.dataset.id;
            const size = this.dataset.size;
            const quantity = parseInt(this.value);
            
            if (quantity < 1) {
                this.value = 1;
                return;
            }
            
            // Debounce để tránh gửi quá nhiều request
            timeout = setTimeout(() => {
                const originalValue = this.value;
                this.disabled = true;
                
                sendAjaxRequest({
                    action: 'update_quantity',
                    id: id,
                    size: size,
                    quantity: quantity
                }, (result) => {
                    if (result.success) {
                        showMessage(result.message, 'success');
                        updateCartTotals();
                    } else {
                        showMessage(result.message, 'error');
                        // Khôi phục giá trị cũ nếu có lỗi
                        this.value = this.defaultValue;
                    }
                    this.disabled = false;
                });
            }, 500);
        });
    });

    // Xử lý nút tăng/giảm số lượng
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.dataset.action === 'increase' ? 'increase_quantity' : 'decrease_quantity';
            const id = this.dataset.id;
            const size = this.dataset.size;
            const quantityInput = this.parentElement.querySelector('.quantity-input');
            const currentQuantity = parseInt(quantityInput.value);
            
            this.disabled = true;
            
            sendAjaxRequest({
                action: action,
                id: id,
                size: size
            }, (result) => {
                if (result.success) {
                    showMessage(result.message, 'success');
                    
                    // Cập nhật số lượng trong input
                    if (action === 'increase_quantity') {
                        quantityInput.value = currentQuantity + 1;
                    } else if (action === 'decrease_quantity') {
                        if (currentQuantity > 1) {
                            quantityInput.value = currentQuantity - 1;
                        } else {
                            // Nếu số lượng = 1 và giảm, xóa sản phẩm
                            const productRow = this.closest('.row.mb-4');
                            if (productRow) {
                                productRow.style.transition = 'opacity 0.3s ease';
                                productRow.style.opacity = '0';
                                setTimeout(() => {
                                    productRow.remove();
                                    updateCartTotals();
                                    
                                    // Kiểm tra nếu giỏ hàng trống
                                    if (document.querySelectorAll('.quantity-input').length === 0) {
                                        location.reload();
                                    }
                                }, 300);
                            }
                        }
                    }
                    
                    updateCartTotals();
                } else {
                    showMessage(result.message, 'error');
                }
                this.disabled = false;
            });
        });
    });

    // Xử lý nút xóa sản phẩm
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                return;
            }
            
            const id = this.dataset.id;
            const size = this.dataset.size;
            const productRow = this.closest('.row.mb-4');
            
            this.disabled = true;
            
            sendAjaxRequest({
                action: 'remove_item',
                id: id,
                size: size
            }, (result) => {
                if (result.success) {
                    showMessage(result.message, 'success');
                    
                    // Ẩn sản phẩm với animation
                    if (productRow) {
                        productRow.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        productRow.style.opacity = '0';
                        productRow.style.transform = 'translateX(-100%)';
                        
                        setTimeout(() => {
                            productRow.remove();
                            updateCartTotals();
                            
                            // Kiểm tra nếu giỏ hàng trống
                            if (document.querySelectorAll('.quantity-input').length === 0) {
                                location.reload();
                            }
                        }, 300);
                    }
                } else {
                    showMessage(result.message, 'error');
                }
                this.disabled = false;
            });
        });
    });
});
</script>
