<?php

$tmp = '/tmp/kingsbarber';

$paths = [
    $tmp,
    $tmp . '/bootstrap/cache',
    $tmp . '/storage',
    $tmp . '/storage/framework',
    $tmp . '/storage/framework/cache',
    $tmp . '/storage/framework/cache/data',
    $tmp . '/storage/framework/sessions',
    $tmp . '/storage/framework/views',
    $tmp . '/storage/logs',
];

foreach ($paths as $p) {
    if (! is_dir($p)) {
        @mkdir($p, 0755, true);
    }
}

putenv("APP_CONFIG_CACHE={$tmp}/bootstrap/cache/config.php");
putenv("APP_ROUTES_CACHE={$tmp}/bootstrap/cache/routes.php");
putenv("APP_SERVICES_CACHE={$tmp}/bootstrap/cache/services.php");
putenv("APP_PACKAGES_CACHE={$tmp}/bootstrap/cache/packages.php");
putenv("APP_EVENTS_CACHE={$tmp}/bootstrap/cache/events.php");
putenv("VIEW_COMPILED_PATH={$tmp}/storage/framework/views");
putenv("LARAVEL_STORAGE_PATH={$tmp}/storage");

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain');
    echo "LARAVEL BOOTSTRAP ERROR\n\n";
    echo "Class:   " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File:    " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo substr($e->getTraceAsString(), 0, 2000);
}
