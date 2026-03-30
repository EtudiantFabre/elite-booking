#!/usr/bin/env bash
set -e

cd /var/www/html

echo "Node version:"
node -v
npm -v
which node
which npm

echo "Running composer install..."
composer install --no-dev --optimize-autoloader --no-interaction

if [ ! -f .env ]; then
  echo "No .env file found, skipping key:generate"
else
  echo "Generating application key if needed..."
  php artisan key:generate --force || true
fi

echo "Installing node modules..."
npm install

echo "Building Vite assets..."
npm run build

echo "Checking Vite manifest..."
ls -la /var/www/html/public/build || true
test -f /var/www/html/public/build/manifest.json && echo "manifest found" || echo "manifest missing"

echo "Clearing old caches..."
php artisan optimize:clear || true

echo "Caching config..."
php artisan config:cache || true

echo "Caching routes..."
php artisan route:cache || true

echo "Running migrations..."
php artisan migrate --force || true