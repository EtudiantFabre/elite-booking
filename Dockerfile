# Stage 1: build front avec une image Node adaptée
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# Stage 2: image PHP/Nginx finale
FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html
COPY . /var/www/html

RUN docker-php-ext-install bcmath
RUN sed -i 's|^listen = .*|listen = 127.0.0.1:9000|g' /usr/local/etc/php-fpm.d/www.conf

# Copier seulement les assets buildés
COPY --from=frontend /app/public/build /var/www/html/public/build

ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV PORT=10000
ENV COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 10000