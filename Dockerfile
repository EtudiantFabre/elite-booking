# Stage 1: PHP dependencies
FROM composer:2.7 as vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Stage 2: Frontend assets
FROM node:20-alpine as frontend
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm install
COPY . .
# CRITICAL: Copy vendor from the vendor stage so Vite can resolve Ziggy during build
COPY --from=vendor /app/vendor/ ./vendor/
RUN npm run build

# Stage 3: Final production image
FROM richarvey/nginx-php-fpm:3.1.6

# Set working directory
WORKDIR /var/www/html

# Copy all project files
COPY . .

# Copy build artifacts from previous stages
COPY --from=vendor /app/vendor/ ./vendor/
COPY --from=frontend /app/public/build/ ./public/build/

# Image config
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# List of PHP extensions to install/enable
ENV PHP_EXTENSIONS "bcmath gd zip intl pdo_mysql pdo_pgsql"

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root (if needed at runtime)
ENV COMPOSER_ALLOW_SUPERUSER 1

# Ensure start.sh is executable
RUN chmod +x /var/www/html/start.sh

# Use the project's start.sh as the start command
CMD ["/var/www/html/start.sh"]