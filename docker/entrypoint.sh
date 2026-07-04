#!/bin/sh

set -e

echo "Waiting for MariaDB..."

until php artisan migrate:status >/dev/null 2>&1
do
    sleep 2
done

echo "MariaDB is ready."

php artisan migrate --force

php artisan storage:link || true

exec php-fpm
