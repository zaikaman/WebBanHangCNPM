<?php
/**
 * Environment Helper Functions
 * Các hàm hỗ trợ cho việc quản lý cấu hình môi trường
 */

// Tránh định nghĩa functions nhiều lần
if (!function_exists('env')) {

/**
 * Lấy giá trị từ biến môi trường
 * @param string $key Tên biến
 * @param mixed $default Giá trị mặc định
 * @return mixed
 */
function env($key, $default = null) {
    return $_ENV[$key] ?? $default;
}

/**
 * Kiểm tra xem có đang ở môi trường local không
 * @return bool
 */
function is_local() {
    return env('APP_ENV') === 'local';
}

/**
 * Kiểm tra xem có đang ở môi trường production không
 * @return bool
 */
function is_production() {
    return env('APP_ENV') === 'production';
}

/**
 * Lấy URL base của ứng dụng
 * @return string
 */
function app_url() {
    return rtrim(env('APP_URL', 'http://localhost'), '/');
}

/**
 * Tạo URL đầy đủ từ path
 * @param string $path
 * @return string
 */
function url($path = '') {
    return app_url() . '/' . ltrim($path, '/');
}

/**
 * Lấy thông tin cấu hình database
 * @return array
 */
function db_config() {
    return [
        'host' => env('DB_HOST', 'localhost'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'database' => env('DB_DATABASE', 'webbanhang_cnpm'),
        'port' => env('DB_PORT', 3306)
    ];
}

/**
 * Lấy thông tin cấu hình email
 * @return array
 */
function mail_config() {
    return [
        'mailer' => env('MAIL_MAILER', 'smtp'),
        'host' => env('MAIL_HOST', 'smtp.gmail.com'),
        'port' => env('MAIL_PORT', 587),
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        'from_address' => env('MAIL_FROM_ADDRESS'),
        'from_name' => env('MAIL_FROM_NAME', 'Web Bán Hàng')
    ];
}

/**
 * Lấy thông tin cấu hình MoMo
 * @return array
 */
function momo_config() {
    return [
        'partner_code' => env('MOMO_PARTNER_CODE'),
        'access_key' => env('MOMO_ACCESS_KEY'),
        'secret_key' => env('MOMO_SECRET_KEY'),
        'endpoint' => env('MOMO_ENDPOINT', 'https://test-payment.momo.vn/gw_payment/transactionProcessor')
    ];
}

/**
 * Lấy thông tin cấu hình VNPay
 * @return array
 */
function vnpay_config() {
    return [
        'tmn_code' => env('VNPAY_TMN_CODE'),
        'hash_secret' => env('VNPAY_HASH_SECRET'),
        'url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html')
    ];
}

/**
 * Kiểm tra xem có đang chạy trên HTTPS không
 * @return bool
 */
function is_https() {
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
           $_SERVER['SERVER_PORT'] == 443 ||
           (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
}

/**
 * Force HTTPS redirect nếu cấu hình yêu cầu
 * @return void
 */
function force_https() {
    if (env('FORCE_HTTPS', false) && !is_https() && is_production()) {
        $redirect_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('Location: ' . $redirect_url, true, 301);
        exit();
    }
}

/**
 * Lấy base path của ứng dụng
 * @return string
 */
function base_path($path = '') {
    $base = dirname(dirname(__DIR__));
    return $base . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
}

/**
 * Kiểm tra xem có đang chạy trên InfinityFree không
 * @return bool
 */
function is_infinityfree() {
    return isset($_SERVER['HTTP_HOST']) && 
           (strpos($_SERVER['HTTP_HOST'], 'infinityfreeapp.com') !== false ||
            strpos($_SERVER['HTTP_HOST'], 'rf.gd') !== false ||
            strpos($_SERVER['HTTP_HOST'], 'eu.org') !== false);
}

} // End function_exists check
?>
