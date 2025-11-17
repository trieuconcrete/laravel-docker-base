#!/bin/bash

cd /var/www/webroot/laravel-docker-base || exit
git pull origin Master
cd src
composer install --no-dev
php artisan migrate --force
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
chown -R www-data:www-data storage bootstrap/cache