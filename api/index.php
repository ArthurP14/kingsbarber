<?php

// Vercel only allows writes to /tmp — redirect Laravel's runtime dirs there
$_ENV['APP_CONFIG_CACHE']      = $_ENV['APP_CONFIG_CACHE']      ?? '/tmp/config.php';
$_ENV['APP_ROUTES_CACHE']      = $_ENV['APP_ROUTES_CACHE']      ?? '/tmp/routes.php';
$_ENV['APP_SERVICES_CACHE']    = $_ENV['APP_SERVICES_CACHE']    ?? '/tmp/services.php';
$_ENV['APP_PACKAGES_CACHE']    = $_ENV['APP_PACKAGES_CACHE']    ?? '/tmp/packages.php';
$_ENV['APP_EVENTS_CACHE']      = $_ENV['APP_EVENTS_CACHE']      ?? '/tmp/events.php';
$_ENV['VIEW_COMPILED_PATH']    = $_ENV['VIEW_COMPILED_PATH']    ?? '/tmp/views';

// Ensure the views directory exists
if (! is_dir('/tmp/views')) {
    @mkdir('/tmp/views', 0755, true);
}

require __DIR__ . '/../public/index.php';
