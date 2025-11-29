# Use official PHP 8.4 FPM image
FROM php:8.4-fpm

# Install system packages and PHP extensions required by Laravel + common libs
RUN apt-get update && apt-get install -y \
    git unzip libonig-dev libzip-dev libpng-dev libicu-dev libxml2-dev \
    libcurl4-openssl-dev libssl-dev zlib1g-dev supervisor curl npm nodejs make pkg-config libsodium-dev \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath intl zip opcache openssl \
 && git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis \
 && ls -la /usr/src/php/ext/redis \
 && ls -la /usr/src/php/ext/redis/modules \
 && docker-php-ext-install redis \
 && rm -rf /usr/src/php/ext/redis \
 && rm -rf /var/lib/apt/lists/*

# Install Composer (copy from composer official image)
COPY --from=composer:2.9 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first to leverage Docker cache
COPY composer.json composer.lock ./

# Install PHP dependencies (production)
RUN composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction --prefer-dist

# Copy rest of the application
COPY . .

# Build frontend (optional: consider building assets in CI instead)
RUN if [ -f package.json ]; then \
      apt-get update && apt-get install -y nodejs npm && npm ci --silent && npm run build --silent; \
    fi

# Set permissions for storage and bootstrap cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]