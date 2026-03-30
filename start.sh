#!/usr/bin/env bash
set -e

cd /var/www/html

echo "Checking vendor..."
if [ ! -f vendor/autoload.php ]; then
  echo "ERROR: vendor/autoload.php not found"
  exit 1
fi

if [ -f /var/www/html/laravel-deploy.sh ]; then
  echo "Running deploy script..."
  chmod +x /var/www/html/laravel-deploy.sh
  /var/www/html/laravel-deploy.sh
else
  echo "WARNING: laravel-deploy.sh not found"
fi

echo "Starting services..."
exec supervisord -n