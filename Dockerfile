FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html
COPY . /var/www/html

RUN docker-php-ext-install bcmath

RUN apk add --no-cache curl \
 && curl -fsSL https://nodejs.org/dist/v22.12.0/node-v22.12.0-linux-x64.tar.xz -o /tmp/node.tar.xz \
 && tar -xJf /tmp/node.tar.xz -C /usr/local --strip-components=1 \
 && rm /tmp/node.tar.xz \
 && ln -sf /usr/local/bin/node /usr/bin/node \
 && ln -sf /usr/local/bin/npm /usr/bin/npm \
 && node -v \
 && npm -v

RUN sed -i 's|^listen = .*|listen = 127.0.0.1:9000|g' /usr/local/etc/php-fpm.d/www.conf

ENV PATH="/usr/local/bin:/usr/bin:${PATH}"
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
#CMD ["/start.sh"]