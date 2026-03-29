#!/usr/bin/env bash
set -e

cd /var/www/html

echo "Checking vendor..."
if [ ! -f vendor/autoload.php ]; then
  echo "ERROR: vendor/autoload.php not found"
  exit 1
fi

echo "Caching config..."
php artisan config:cache || true

echo "Caching routes..."
php artisan route:cache || true

echo "Running migrations..."
php artisan migrate --force || true

echo "Starting services..."
exec supervisord -n