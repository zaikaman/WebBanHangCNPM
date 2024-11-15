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
$(document).on('submit', 'form[data-ajax="true"]', function(e) {
    e.preventDefault();
    const form = $(this);
    const submitButton = form.find('button[type="submit"]');
    
    // Disable submit button to prevent double submission
    submitButton.prop('disabled', true);
    
    // Show loading indicator
    showLoading();
    
    $.ajax({
        url: form.attr('action'),
        method: form.attr('method') || 'GET',
        data: form.serialize(),
        success: function(response) {
            // Handle specific form responses
            if (form.hasClass('login_form')) {
                handleLoginResponse(response);
            } else if (form.attr('id') === 'filterForm') {
                handleFilterResponse(response);
            } else {
                // Default handling
                $('.main_content').html(response);
            }
            
            // Update URL if needed
            if (form.data('update-url')) {
                history.pushState(
                    {path: form.attr('action')}, 
                    '', 
                    form.attr('action')
                );
            }
        },
        error: function(xhr, status, error) {
            console.error('Form submission error:', error);
            // Show error message to user
            alert('Có lỗi xảy ra. Vui lòng thử lại.');
        },
        complete: function() {
            // Re-enable submit button
            submitButton.prop('disabled', false);
            hideLoading();
        }
    });
});

// Handle login form response
function handleLoginResponse(response) {
    if (response.success) {
        window.location.reload(); // Reload page after successful login
    } else {
        $('#login_fail').show();
    }
}

// Handle filter form response
function handleFilterResponse(response) {
    $('.main_content').html(response);
    // Update URL with filter parameters
    const queryString = $('#filterForm').serialize();
    const newUrl = `index.php?${queryString}`;
    history.pushState({path: newUrl}, '', newUrl);
}

// Thêm cache cho AJAX requests
const pageCache = new Map();

// Sửa lại hàm loadContent
function loadContent(url, targetElement) {
    showLoading();
    
    // Kiểm tra cache
    if (pageCache.has(url)) {
        $(targetElement).html(pageCache.get(url));
        history.pushState({path: url}, '', url);
        hideLoading();
        return;
    }

    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            // Lưu vào cache
            pageCache.set(url, response);
            $(targetElement).html(response);
            history.pushState({path: url}, '', url);
            
            // Reinitialize any necessary scripts
            reinitializeScripts();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        },
        complete: function() {
            hideLoading();
        }
    });
}

// Thêm function để reinitialize các script cần thiết
function reinitializeScripts() {
    // Reinitialize any third-party plugins
    if (typeof initializeSlider === 'function') initializeSlider();
    if (typeof initializeTabs === 'function') initializeTabs();
    
    // Re-bind event handlers
    bindEventHandlers();
}

// Thêm function để xử lý history state
function handlePageNavigation() {
    // Xử lý click cho tất cả các link trong trang
    $(document).on('click', 'a[href^="index.php"]', function(e) {
        // Bỏ qua các link có target="_blank" hoặc download attribute
        if ($(this).attr('target') === '_blank' || $(this).attr('download')) {
            return;
        }
        
        e.preventDefault();
        const url = $(this).attr('href');
        loadContent(url, '.main_content');
    });

    // Xử lý form submit
    $(document).on('submit', 'form:not([target="_blank"])', function(e) {
        e.preventDefault();
        const form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method') || 'GET',
            data: form.serialize(),
            success: function(response) {
                $('.main_content').html(response);
                history.pushState({path: form.attr('action')}, '', form.attr('action'));
            }
        });
    });

    // Xử lý browser back/forward
    window.onpopstate = function(event) {
        if (event.state && event.state.path) {
            loadContent(event.state.path, '.main_content');
        }
    };
}

// Giới hạn kích thước cache
function limitCacheSize(maxSize = 20) {
    if (pageCache.size > maxSize) {
        const firstKey = pageCache.keys().next().value;
        pageCache.delete(firstKey);
    }
}

function showNotification(message, type = 'success') {
    const notification = $('<div>')
        .addClass(`notification ${type}`)
        .text(message)
        .appendTo('body');
    
    setTimeout(() => notification.remove(), 3000);
}

function lazyLoadImages() {
    $('img[data-src]').each(function() {
        if (isElementInViewport(this)) {
            $(this).attr('src', $(this).data('src'));
            $(this).removeAttr('data-src');
        }
    });
}

// Kiểm tra element có trong viewport
function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Gọi khi load content mới
$(document).on('contentLoaded', lazyLoadImages);

// Document ready
$(document).ready(function() {
    handlePageNavigation();
});

