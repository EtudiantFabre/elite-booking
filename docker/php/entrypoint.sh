#!/bin/sh
set -e

echo "🚀 Laravel container starting..."

cd /var/www

if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ -n "$PORT" ]; then
    export PORT
else
    export PORT=10000
fi

echo "🛠 Generating nginx config on port $PORT..."
envsubst '${PORT}' < /etc/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf

if [ "$APP_ROLE" = "app" ] || [ -z "$APP_ROLE" ]; then
    echo "⏳ Waiting for database..."

    until php -r "
    try {
        \$url = getenv('DB_URL');
        if (\$url) {
            \$parts = parse_url(\$url);
            \$scheme = \$parts['scheme'] ?? 'pgsql';
            \$host = \$parts['host'] ?? 'localhost';
            \$port = \$parts['port'] ?? 5432;
            \$db   = isset(\$parts['path']) ? ltrim(\$parts['path'], '/') : '';
            \$user = \$parts['user'] ?? '';
            \$pass = \$parts['pass'] ?? '';
            new PDO(\"\$scheme:host=\$host;port=\$port;dbname=\$db\", \$user, \$pass);
        } else {
            \$driver = getenv('DB_CONNECTION') ?: 'pgsql';
            \$host = getenv('DB_HOST');
            \$port = getenv('DB_PORT') ?: 5432;
            \$db = getenv('DB_DATABASE');
            \$user = getenv('DB_USERNAME');
            \$pass = getenv('DB_PASSWORD');
            new PDO(\"\$driver:host=\$host;port=\$port;dbname=\$db\", \$user, \$pass);
        }
    } catch (Exception \$e) {
        fwrite(STDERR, \$e->getMessage() . PHP_EOL);
        exit(1);
    }
    "; do
        sleep 2
    done

    echo "✅ Database is ready"

    php artisan key:generate --force || true
    php artisan storage:link || true
    php artisan migrate --force

    echo "🔍 Checking seed status..."

    COUNT=$(php artisan tinker --execute="echo class_exists('\\Spatie\\Permission\\Models\\Permission') ? \\Spatie\\Permission\\Models\\Permission::count() : 0;")

    echo "🔢 Permission count: $COUNT"

    if [ "$COUNT" -eq 0 ]; then
        echo "🌱 First run detected → running seeders"
        php artisan db:seed --force
    else
        echo "✔️ Already seeded"
    fi
fi

echo "🚀 Starting php-fpm..."
php-fpm -D

echo "🚀 Starting nginx..."
exec "$@"