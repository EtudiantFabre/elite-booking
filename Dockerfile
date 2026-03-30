# ==============================
# STAGE 1: FRONTEND (VITE BUILD)
# ==============================
FROM node:22-alpine AS frontend

WORKDIR /app

# Copier uniquement les fichiers nécessaires au build
COPY package*.json ./
RUN npm install

# Copier le reste du projet
COPY . .

# Build Vite
RUN npm run build


# ==============================
# STAGE 2: BACKEND (PHP + NGINX)
# ==============================
FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html

# Copier le projet Laravel
COPY . /var/www/html

# Installer extension PHP
RUN docker-php-ext-install bcmath

# Corriger PHP-FPM (IMPORTANT)
RUN sed -i 's|^listen = .*|listen = 127.0.0.1:9000|g' /usr/local/etc/php-fpm.d/www.conf

# Copier les assets Vite buildés
COPY --from=frontend /app/public/build /var/www/html/public/build

# Config Render / Laravel
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