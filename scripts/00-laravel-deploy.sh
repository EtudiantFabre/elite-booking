#!/usr/bin/env bash
set -e

cd /var/www/html

echo "Running composer install..."
composer install --no-dev --optimize-autoloader --no-interaction

if [ ! -f .env ]; then
  echo "No .env file found"
fi

echo "Generating application key if needed..."
php artisan key:generate --force || true

echo "Caching config..."
php artisan config:cache || true

echo "Caching routes..."
php artisan route:cache || true

echo "Running migrations..."
php artisan migrate --force || true