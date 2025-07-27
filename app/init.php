<?php
require_once 'core/Config.php';
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Database.php';

define('BASE_PATH', realpath(__DIR__ . '/../'));
define('PUBLIC_PATH', BASE_PATH . '/public');

define('UPLOAD_DIR', 'images/products'); // Không có 'public/' ở đây!

if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $script_name = dirname($_SERVER['SCRIPT_NAME']);
    define('BASE_URL', rtrim($protocol . '://' . $host . $script_name, '/'));
}
