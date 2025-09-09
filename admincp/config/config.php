<?php
// Tránh load nhiều lần
if (defined('CONFIG_LOADED')) {
    return;
}

// Load dotenv
require_once dirname(__FILE__) . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env file
$dotenv = Dotenv::createImmutable(dirname(__FILE__) . '/../../');
$dotenv->load();

// Include helper functions
require_once dirname(__FILE__) . '/env_helper.php';

// Database configuration from .env
$db_config = db_config();
$mysqli = new mysqli(
    $db_config['host'],
    $db_config['username'], 
    $db_config['password'],
    $db_config['database'],
    $db_config['port']
);

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Set charset to UTF-8
$mysqli->set_charset("utf8");

// Define other environment variables (chỉ define nếu chưa tồn tại)
if (!defined('APP_ENV')) define('APP_ENV', env('APP_ENV', 'local'));
if (!defined('APP_DEBUG')) define('APP_DEBUG', env('APP_DEBUG', true));
if (!defined('APP_URL')) define('APP_URL', env('APP_URL', 'http://localhost'));
if (!defined('TIMEZONE')) define('TIMEZONE', env('TIMEZONE', 'Asia/Ho_Chi_Minh'));

// Set timezone
date_default_timezone_set(TIMEZONE);

// Đánh dấu đã load config
define('CONFIG_LOADED', true);
?>