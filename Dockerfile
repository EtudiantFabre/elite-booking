FROM php:8.2-fpm

ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    default-mysql-client \
    git \
    unzip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Configurer GD AVANT installation
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

RUN docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    mbstring \
    xml \
    zip \
    exif \
    pcntl \
    intl \
    gd \
    ftp

# Redis
RUN pecl install redis && docker-php-ext-enable redis

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copier d'abord les fichiers Composer
COPY composer.json composer.lock ./

# RUN composer install \
#     --no-interaction \
#     --prefer-dist \
#     --optimize-autoloader \
#     --no-scripts
RUN composer install -vvv --no-interaction --prefer-dist --no-scripts

# Copier le projet ensuite
COPY . .

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]

CMD ["php-fpm"]