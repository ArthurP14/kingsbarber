<?php
header('Content-Type: text/plain');
echo "PHP: " . PHP_VERSION . "\n";
echo "Extensions: " . implode(', ', get_loaded_extensions()) . "\n";
echo "APP_KEY env: " . (getenv('APP_KEY') ? 'set (' . strlen(getenv('APP_KEY')) . ' chars)' : 'NOT SET') . "\n";
echo "APP_ENV env: " . (getenv('APP_ENV') ?: 'NOT SET') . "\n";
echo "DB_HOST env: " . (getenv('DB_HOST') ?: 'NOT SET') . "\n";
echo "storage dir writable: " . (is_writable('/tmp') ? 'yes' : 'no') . "\n";
