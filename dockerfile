# Pilih base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies sistem dan ekstensi PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install pdo_mysql zip gd

# Copy composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copy seluruh file ke working directory
COPY . .

# Install dependencies Laravel
RUN composer install --no-scripts --no-autoloader --prefer-dist --ignore-platform-req=ext-gd

# Permission untuk storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan perintah artisan optimize
RUN php artisan optimize
