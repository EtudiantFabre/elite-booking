#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

# Caching config
echo "Caching config..."
php artisan config:cache

# Caching routes
echo "Caching routes..."
php artisan route:cache

# Running migrations
echo "Running migrations..."
php artisan migrate --force