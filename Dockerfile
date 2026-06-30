FROM php:8.2-apache

RUN a2enmod rewrite \
 && apt-get update \
 && apt-get install -y --no-install-recommends libzip-dev unzip \
 && docker-php-ext-install pdo pdo_mysql mysqli zip \
 && rm -rf /var/lib/apt/lists/*

COPY ./expense-tracker/ /var/www/html/

RUN mkdir -p /var/www/html/uploads/invoices \
 && chown -R www-data:www-data /var/www/html

EXPOSE 80
