# --------------------------------------------------------------------------
# Stage 1: Build Frontend Assets (Node.js)
# --------------------------------------------------------------------------
FROM node:20-slim AS node_builder

WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources ./resources 
COPY . . 
RUN npm ci && npm run build

# --------------------------------------------------------------------------
# Stage 2: Build PHP Application (Apache)
# --------------------------------------------------------------------------

FROM php:8.4-apache


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
    autoconf gcc g++ make pkg-config \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath intl zip opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get purge -y --auto-remove autoconf gcc g++ make pkg-config \
    && rm -rf /var/lib/apt/lists/*


RUN a2enmod rewrite


ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. Configure PHP (Optional)
RUN echo "upload_max_filesize=10M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=10M" >> /usr/local/etc/php/conf.d/uploads.ini

# 4. Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 5. Install PHP Dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction --prefer-dist --no-scripts

# 6. Copy Application Code
COPY . .

# 7. Copy Frontend Assets
COPY --from=node_builder /app/public/build /var/www/html/public/build

# 8. Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# CHANGE 3: Apache listens on Port 80 (Railway maps this automatically)
EXPOSE 80

# CHANGE 4: Use the default Apache start command
CMD ["apache2-foreground"]