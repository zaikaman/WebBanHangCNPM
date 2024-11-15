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

// Cache cho AJAX requests
const pageCache = new Map();

function loadContent(url, targetElement) {
    // Kiểm tra cache
    if (pageCache.has(url)) {
        $(targetElement).html(pageCache.get(url));
        history.pushState({path: url}, '', url);
        return;
    }

    $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
            // Lưu vào cache
            pageCache.set(url, response);
            $(targetElement).html(response);
            history.pushState({path: url}, '', url);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Xử lý click cho tất cả các link có data-ajax="true"
$(document).on('click', 'a[data-ajax="true"]', function(e) {
    e.preventDefault();
    const url = $(this).attr('href');
    loadContent(url, '.main_content');
});

// Xử lý form submit
$(document).on('submit', 'form[data-ajax="true"]', function(e) {
    e.preventDefault();
    const form = $(this);
    
    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: form.serialize(),
        success: function(response) {
            $('.main_content').html(response);
            const newUrl = form.attr('action') + '?' + form.serialize();
            history.pushState(null, '', newUrl);
        }
    });
});

// Xử lý nút back/forward của trình duyệt
window.onpopstate = function(event) {
    if (event.state && event.state.path) {
        loadContent(event.state.path, '.main_content');
    }
};

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

