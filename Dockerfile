FROM composer:latest AS composer

WORKDIR /app

COPY composer.json ./

RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

FROM php:8-apache

RUN docker-php-ext-install mysqli

WORKDIR /var/www

COPY configuration.php .
COPY --from=composer /app/vendor ./vendor

WORKDIR /var/www/html

COPY public .
