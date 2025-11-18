document.addEventListener('DOMContentLoaded', function() {
    // ===================================
    // CHECKBOX FUNCTIONALITY
    // ===================================
    
    const selectAllCheckbox = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.cart-checkbox-item');
    
    // Hàm cập nhật trạng thái checkbox "Chọn tất cả"
    function updateSelectAllCheckbox() {
        const totalCheckboxes = itemCheckboxes.length;
        const checkedCheckboxes = document.querySelectorAll('.cart-checkbox-item:checked').length;
        
        if (checkedCheckboxes === 0) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.classList.remove('indeterminate');
        } else if (checkedCheckboxes === totalCheckboxes) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.classList.remove('indeterminate');
        } else {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.classList.add('indeterminate');
        }
    }
    
    // Hàm cập nhật giao diện sản phẩm khi checkbox thay đổi
    function updateProductRowAppearance(checkbox) {
        const productRow = checkbox.closest('.product-item');
        if (checkbox.checked) {
            productRow.classList.remove('unchecked');
        } else {
            productRow.classList.add('unchecked');
        }
    }
    
    // Xử lý sự kiện "Chọn tất cả"
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
                updateProductRowAppearance(checkbox);
            });
            this.classList.remove('indeterminate');
            updateCartTotals();
        });
    }
    
    // Xử lý sự kiện checkbox từng sản phẩm
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllCheckbox();
            updateProductRowAppearance(this);
            updateCartTotals();
        });
    });
    
    // Khởi tạo trạng thái ban đầu
    updateSelectAllCheckbox();
    
    // ===================================
    // ORIGINAL FUNCTIONALITY
    // ===================================
    
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
        // Use root-based absolute path for ajax cart endpoint
        const apiUrl = '/pages/main/ajax_cart.php';
        
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
        
        // Chỉ tính các sản phẩm được chọn
        document.querySelectorAll('.cart-checkbox-item:checked').forEach(checkbox => {
            const productRow = checkbox.closest('.product-item');
            const quantityInput = productRow.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value) || 0;
            const price = parseInt(productRow.dataset.productPrice) || 0;
            
            totalQuantity += quantity;
            totalPrice += (price * quantity);
        });
        
        // Cập nhật số lượng sản phẩm được chọn
        const quantityElement = document.getElementById('selectedQuantity');
        if (quantityElement) {
            quantityElement.textContent = totalQuantity;
        }
        
        // Cập nhật thành tiền
        const totalElement = document.getElementById('selectedTotal');
        if (totalElement) {
            totalElement.textContent = new Intl.NumberFormat('vi-VN').format(totalPrice) + 'đ';
        }
        
        // Cập nhật số mặt hàng ở header
        const itemCountElement = document.querySelector('.mb-0.text-muted');
        if (itemCountElement) {
            const itemCount = document.querySelectorAll('.cart-checkbox-item').length;
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
                    productRow.dataset.productSize = newSize;

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
                                    
                                    // Cập nhật lại danh sách checkboxes sau khi xóa
                                    const remainingCheckboxes = document.querySelectorAll('.cart-checkbox-item');
                                    if (remainingCheckboxes.length > 0) {
                                        updateSelectAllCheckbox();
                                    }
                                    
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
                            
                            // Cập nhật lại danh sách checkboxes sau khi xóa
                            const remainingCheckboxes = document.querySelectorAll('.cart-checkbox-item');
                            if (remainingCheckboxes.length > 0) {
                                updateSelectAllCheckbox();
                            }
                            
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
    
    // ===================================
    // XỬ LÝ NÚT "TIẾP THEO"
    // ===================================
    
    const btnProceedToShipping = document.getElementById('btnProceedToShipping');
    if (btnProceedToShipping) {
        btnProceedToShipping.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Lấy danh sách sản phẩm được chọn
            const selectedProducts = [];
            document.querySelectorAll('.cart-checkbox-item:checked').forEach(checkbox => {
                const productRow = checkbox.closest('.product-item');
                selectedProducts.push({
                    id: checkbox.dataset.id,
                    size: checkbox.dataset.size
                });
            });
            
            // Kiểm tra có sản phẩm được chọn không
            if (selectedProducts.length === 0) {
                showMessage('Vui lòng chọn ít nhất một sản phẩm để tiếp tục', 'error');
                return;
            }
            
            // Gửi danh sách sản phẩm được chọn lên server
            sendAjaxRequest({
                action: 'save_selected_products',
                selected_products: JSON.stringify(selectedProducts)
            }, (result) => {
                if (result.success) {
                    // Chuyển sang trang vận chuyển
                    window.location.href = 'index.php?quanly=vanChuyen';
                } else {
                    showMessage(result.message || 'Có lỗi xảy ra, vui lòng thử lại', 'error');
                }
            });
        });
    }
});
        });
    }
});
);