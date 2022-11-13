FROM composer:latest AS composer

WORKDIR /app

COPY composer.json .

RUN composer install

FROM php:8-apache

RUN docker-php-ext-install mysqli

WORKDIR /var/www

COPY .env .
COPY configuration.php .

COPY --from=composer /app/vendor ./vendor

WORKDIR /var/www/html

COPY public .
