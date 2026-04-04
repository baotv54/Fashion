FROM php:8.2-apache

# Cài extensions cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring gd bcmath opcache

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy code vào container
WORKDIR /var/www/html
COPY . .

# Cài dependencies
RUN composer install --no-dev --optimize-autoloader

# Cấu hình Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

# Phân quyền storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80