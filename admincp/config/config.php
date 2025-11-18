<?php
// Tránh load nhiều lần
if (defined('CONFIG_LOADED')) {
    return;
}

// Load dotenv
require_once dirname(__FILE__) . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env file - kiểm tra môi trường
$envPath = dirname(__FILE__) . '/../../';

// Chỉ load .env nếu file tồn tại (không cần trên Heroku - dùng Config Vars)
if (file_exists($envPath . '.env') || file_exists($envPath . '.env.production')) {
    try {
        $dotenv = Dotenv::createImmutable($envPath);

        // Nếu có file .env.production trong production environment
        if (file_exists($envPath . '.env.production') && 
            (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'great-site.net') !== false)) {
            $dotenv = Dotenv::createImmutable($envPath, '.env.production');
        }

        $dotenv->load();
    } catch (\Exception $e) {
        // Log error không output
        error_log("Dotenv load error: " . $e->getMessage());
    }
}

// Include helper functions
require_once dirname(__FILE__) . '/env_helper.php';

// Đảm bảo $_ENV có giá trị mặc định nếu .env không load
if (empty($_ENV)) {
    $_ENV = array_merge($_ENV, [
        'DB_HOST' => 'localhost',
        'DB_PORT' => 3306,
        'DB_DATABASE' => 'webbanhang_cnpm',
        'DB_USERNAME' => 'root',
        'DB_PASSWORD' => '',
    ]);
}

// Database configuration from .env
$db_config = db_config();

// Try to connect with error suppression
@$mysqli = new mysqli(
    $db_config['host'],
    $db_config['username'], 
    $db_config['password'],
    $db_config['database'],
    $db_config['port']
);

// Alias cho compatibility
$connect = $mysqli;

// Check connection
if (!$mysqli || $mysqli->connect_errno) {
    $error_msg = $mysqli ? $mysqli->connect_error : 'Connection failed';
    
    // Log error
    error_log("Database connection error: " . $error_msg);
    
    // Return JSON error for AJAX requests
    if (strpos($_SERVER['REQUEST_URI'] ?? '', 'ajax') !== false) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Database connection error']);
        exit();
    }
} else {
    // Set charset to UTF-8 chỉ khi connection thành công
    $mysqli->set_charset("utf8");
}

// Define APP_ENV based on domain
$appEnv = 'local'; // Default to local
if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'great-site.net') !== false) {
    $appEnv = 'production';
}
if (!defined('APP_ENV')) define('APP_ENV', $appEnv);

// Define other environment variables (chỉ define nếu chưa tồn tại)
if (!defined('APP_DEBUG')) define('APP_DEBUG', env('APP_DEBUG', true));
if (!defined('APP_URL')) define('APP_URL', env('APP_URL', 'http://localhost'));
if (!defined('TIMEZONE')) define('TIMEZONE', env('TIMEZONE', 'Asia/Ho_Chi_Minh'));

// Set timezone
date_default_timezone_set(TIMEZONE);

// Đánh dấu đã load config
define('CONFIG_LOADED', true);
?>