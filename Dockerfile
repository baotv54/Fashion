FROM php:8.2-cli

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

# Copy code
WORKDIR /var/www/html
COPY . .

# Cài dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-gd

# Phân quyền
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

CMD php artisan config:clear && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8080