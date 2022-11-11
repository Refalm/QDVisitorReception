FROM php:8-apache

RUN docker-php-ext-install mysqli

WORKDIR /var/www/html

COPY configuration.php /var/www
COPY public .
