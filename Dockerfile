FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    nginx gettext-base \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions storage/logs bootstrap/cache && chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache

COPY docker/nginx.conf /etc/nginx/templates/nginx.conf.template
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
