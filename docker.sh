#!/usr/bin/env bash

# Install vendor dependencies
composer install

# Generate keys
php artisan key:generate
# Run migration
php artisan migrate --seed --force
# Link the storage
php artisan storage:link 2>/dev/null

#Run php-fpm
# php-fpm

/usr/bin/supervisord -c /etc/supervisord.conf
