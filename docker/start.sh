#!/bin/bash
set -e

echo "Starting deploy script..."
echo "PORT=$PORT"

echo "Caching config..."
php artisan config:cache
echo "Config cached"

echo "Caching routes..."
php artisan route:cache
echo "Routes cached"

echo "Running migrations..."
php artisan migrate --force
echo "Migrations done"

echo "Seeding database..."
php artisan db:seed --force
echo "Seed done"

echo "Generating nginx config..."
envsubst '$PORT' < /etc/nginx/templates/nginx.conf.template > /etc/nginx/sites-available/default

echo "Starting nginx..."
service nginx start
echo "Nginx started on port $PORT"

echo "Starting php-fpm..."
php-fpm
