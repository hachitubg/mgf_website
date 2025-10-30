<?php
// includes/config.php
// Edit these values if your XAMPP MySQL settings differ

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mgf_website');
define('DB_USER', 'root');
define('DB_PASS', '');

// If you placed the project in htdocs/mgf-website then BASE_URL should be '/mgf-website'
// Adjust if your setup differs (virtual host, subfolder, etc.)
define('BASE_URL', '/mgf-website');

define('UPLOAD_DIR', __DIR__ . '/../uploads');
define('UPLOAD_URL', BASE_URL . '/uploads');

// Simple timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

?>