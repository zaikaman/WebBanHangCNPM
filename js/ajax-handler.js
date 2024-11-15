function showLoading() {
    $('.ajax-loading').fadeIn();
}

function hideLoading() {
    $('.ajax-loading').fadeOut();
}

// Hàm xử lý chung cho AJAX request
function handleAjaxRequest(options) {
    showLoading();
    return $.ajax({
        url: options.url,
        method: options.method || 'GET',
        data: options.data,
        dataType: options.dataType,
        success: function(response) {
            if (options.success) options.success(response);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            if (options.error) options.error(xhr, status, error);
        },
        complete: function() {
            hideLoading();
        }
    });
}

// Xử lý form submit
function handleFormSubmit(formElement, successCallback) {
    $(formElement).on('submit', function(e) {
        e.preventDefault();
        if ($(this).data('validate') && !validateForm(this)) return false;
        
        handleAjaxRequest({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success: successCallback
        });
    });
}

// Xử lý load content
function loadContent(url, targetElement) {
    handleAjaxRequest({
        url: url,
        success: function(response) {
            $(targetElement).html(response);
            history.pushState({path: url}, '', url);
        }
    });
}

// Xử lý nút back/forward của trình duyệt
window.onpopstate = function(event) {
    if (event.state && event.state.path) {
        loadContent(event.state.path, '.main_content');
    }
};

$(document).ready(function() {
    // Xử lý tất cả các form AJAX
    $(document).on('submit', 'form[data-ajax="true"]', function(e) {
        e.preventDefault();
        const form = $(this);
        
        // Kiểm tra validation nếu form yêu cầu
        if (form.data('validate')) {
            if (typeof window.validateForm === 'function') {
                if (!window.validateForm(form)) {
                    return false;
                }
            }
        }

        handleAjaxRequest({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                if (form.attr('id') === 'shippingForm') {
                    if (response.success) {
                        showNotification('Cập nhật thành công');
                        // Redirect sau khi cập nhật thành công
                        setTimeout(() => {
                            loadContent('index.php?quanly=thongTinThanhToan', '.main_content');
                        }, 1000);
                    } else {
                        showNotification('Có lỗi xảy ra', 'error');
                    }
                } else {
                    $('.main_content').html(response);
                    if (form.attr('id') !== 'filterForm') {
                        const newUrl = form.attr('action') + '?' + form.serialize();
                        window.history.pushState({path: newUrl}, '', newUrl);
                    }
                }
            }
        });
    });

    // Xử lý nút thanh toán
    $(document).on('click', '#checkoutButton', function(e) {
        if ($('#shippingForm').data('validate')) {
            if (!window.validateForm($('#shippingForm'))) {
                e.preventDefault();
                return false;
            }
        }
    });
});

function showNotification(message, type = 'success') {
    const notification = $('<div>')
        .addClass(`notification ${type}`)
        .text(message)
        .appendTo('body');
    
    setTimeout(() => notification.remove(), 3000);
}

