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
        // Lấy base URL từ window location
        const baseUrl = window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')) || '/';
        const apiUrl = baseUrl.includes('WebBanHangCNPM') ? 
            '/WebBanHangCNPM/pages/main/ajax_cart.php' : 
            '/pages/main/ajax_cart.php';
        
        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Response was not JSON');
            }
            return response.json();
        })
        .then(result => {
            if (callback) callback(result);
        })
        .catch(error => {
            console.error('Fetch error:', error);
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
                    const productRow = this.closest('.product-item');
                    productRow.dataset.maxStock = result.new_stock;

                    const quantityControls = productRow.querySelectorAll('[data-size]');
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
            const productItem = this.closest('.product-item');
            const quantityInput = this.parentElement.querySelector('.quantity-input');
            const currentQuantity = parseInt(quantityInput.value);

            if (action === 'increase_quantity') {
                const maxStock = parseInt(productItem.dataset.maxStock);
                if (currentQuantity >= maxStock) {
                    showMessage('Số lượng sản phẩm trong kho không đủ.', 'error');
                    return; // Dừng thực thi
                }
            }
            
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