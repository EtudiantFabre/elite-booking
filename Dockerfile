FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

# Installer l'extension manquante
RUN docker-php-ext-install bcmath

# Installer Node.js (IMPORTANT)
RUN apt-get update && apt-get install -y curl gnupg ca-certificates \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Force PHP-FPM to listen on TCP
RUN sed -i 's|^listen = .*|listen = 127.0.0.1:9000|g' /usr/local/etc/php-fpm.d/www.conf

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV PORT=10000
EXPOSE 10000
# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]