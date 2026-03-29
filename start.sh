#!/usr/bin/env bash

# Caching config
echo "Caching config..."
php artisan config:cache

# Caching routes
echo "Caching routes..."
php artisan route:cache

# Running migrations
echo "Running migrations..."
php artisan migrate --force