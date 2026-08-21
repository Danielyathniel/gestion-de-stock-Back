#!/bin/bash
echo "Starting deploy script..."
php artisan config:cache
echo "Config cached"
php artisan route:cache
echo "Routes cached"
php artisan migrate --force
echo "Migrations done"
service nginx start
echo "Nginx started"
php-fpm