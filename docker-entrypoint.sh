#!/bin/sh
set -e

# Run migrations and seed
php artisan migrate --force
php artisan db:seed --force

# Clear stale caches, then rebuild them
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ensure storage is writable
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# FrankenPHP will look for public/index.php by default when
# the working directory contains a Laravel app.
exec frankenphp run --config /etc/frankenphp/Caddyfile
