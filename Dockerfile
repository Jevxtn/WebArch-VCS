FROM php:8.2-apache

# Enable Apache rewrite support and install PHP extensions required by the app.
RUN a2enmod rewrite \
 && apt-get update \
 && apt-get install -y --no-install-recommends libzip-dev unzip \
 && docker-php-ext-install pdo pdo_mysql mysqli zip \
 && rm -rf /var/lib/apt/lists/*

# Copy the PHP web application into Apache's default document root.
COPY ./expense-tracker/ /var/www/html/

# Ensure upload target exists and web server user can write uploaded files.
RUN mkdir -p /var/www/html/uploads/invoices \
 && chown -R www-data:www-data /var/www/html

# Document that the container listens on HTTP port 80.
EXPOSE 80
