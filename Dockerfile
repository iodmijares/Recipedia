# --------------------------------------------------------------------------
# Stage 1: Build Frontend Assets (Node.js)
# --------------------------------------------------------------------------
FROM node:20-slim AS node_builder

WORKDIR /app
COPY package*.json vite.config.js ./
# If you have a Tailwind config, copy it too
COPY resources ./resources 
# Copy specific folders needed for build, or just COPY . . to be safe
COPY . . 

RUN npm ci && npm run build

# --------------------------------------------------------------------------
# Stage 2: Build PHP Application
# --------------------------------------------------------------------------
FROM php:8.4-fpm

# 1. Install system dependencies and PHP extensions
# We include 'libssl-dev' but DO NOT put 'openssl' in docker-php-ext-install
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    git \
    unzip \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    zlib1g-dev \
    supervisor \
    curl \
    # Build tools for PECL (Redis)
    autoconf gcc g++ make pkg-config \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath intl zip opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    # CLEANUP: Remove build tools to reduce image size
    && apt-get purge -y --auto-remove autoconf gcc g++ make pkg-config \
    && rm -rf /var/lib/apt/lists/*

# 2. Configure PHP (Optional but recommended)
RUN echo "upload_max_filesize=10M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=10M" >> /usr/local/etc/php/conf.d/uploads.ini

# 3. Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 4. Install PHP Dependencies
# We copy composer files first for Docker Layer Caching
COPY composer.json composer.lock ./
# Note: --no-scripts prevents errors because 'artisan' isn't copied yet
RUN composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction --prefer-dist --no-scripts

# 5. Copy Application Code
COPY . .

# 6. Copy Compiled Frontend Assets from Stage 1
# This puts the built CSS/JS into the public folder without installing Node.js here
COPY --from=node_builder /app/public/build /var/www/html/public/build

# 7. Final Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Start
EXPOSE 9000
CMD ["php-fpm"]