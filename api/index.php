<?php
header('Content-Type: text/plain');

echo "=== Vercel PHP Diagnostic ===\n\n";
echo "PHP version:      " . PHP_VERSION . "\n";
echo "APP_KEY:          " . (getenv('APP_KEY') ? 'set (' . strlen(getenv('APP_KEY')) . ' chars)' : 'NOT SET') . "\n";
echo "APP_ENV:          " . (getenv('APP_ENV') ?: 'NOT SET') . "\n";
echo "APP_DEBUG:        " . (getenv('APP_DEBUG') ?: 'NOT SET') . "\n";
echo "APP_URL:          " . (getenv('APP_URL') ?: 'NOT SET') . "\n";
echo "DB_CONNECTION:    " . (getenv('DB_CONNECTION') ?: 'NOT SET') . "\n";
echo "DB_HOST:          " . (getenv('DB_HOST') ?: 'NOT SET') . "\n";
echo "DB_DATABASE:      " . (getenv('DB_DATABASE') ?: 'NOT SET') . "\n";
echo "DB_USERNAME:      " . (getenv('DB_USERNAME') ?: 'NOT SET') . "\n";
echo "DB_PASSWORD:      " . (getenv('DB_PASSWORD') ? 'set' : 'NOT SET') . "\n";
echo "MYSQL_ATTR_SSL_CA:" . (getenv('MYSQL_ATTR_SSL_CA') ?: 'NOT SET') . "\n";
echo "SESSION_DRIVER:   " . (getenv('SESSION_DRIVER') ?: 'NOT SET') . "\n";
echo "\n/tmp is writable: " . (is_writable('/tmp') ? 'YES' : 'NO') . "\n";
echo "pdo_mysql loaded: " . (extension_loaded('pdo_mysql') ? 'YES' : 'NO') . "\n";
echo "openssl loaded:   " . (extension_loaded('openssl') ? 'YES' : 'NO') . "\n";
