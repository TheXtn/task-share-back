#!/bin/bash



# Generate application key if not set
php artisan key:generate --no-interaction --force

# Run database migrations
php artisan migrate --force

# Start PHP-FPM
php-fpm

