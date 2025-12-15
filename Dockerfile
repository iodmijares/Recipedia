# --------------------------------------------------------------------------
# Stage 1: Build Frontend Assets (Node.js)
# --------------------------------------------------------------------------
FROM node:20-slim AS node_builder

WORKDIR /app
COPY package*.json vite.config.js ./
# Copy resources to build assets
COPY resources ./resources 
# We don't need the whole app, just resources, but copying . is safer for some configs
COPY . . 
RUN npm ci && npm run build

# --------------------------------------------------------------------------
# Stage 2: Build PHP Application (Apache)
# --------------------------------------------------------------------------
FROM php:8.4-apache

# 1. Install System Dependencies
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
    # Build tools for extensions
    autoconf gcc g++ make pkg-config \
    # Install PHP Extensions
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath intl zip opcache \
    # Install Redis
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Clean up build tools to reduce image size
    && apt-get purge -y --auto-remove autoconf gcc g++ make pkg-config \
    && rm -rf /var/lib/apt/lists/*

# 2. Apache Configuration
# (MPM configuration moved to the end of the file to ensure it sticks)
RUN a2enmod rewrite

# [FIX] Suppress the "Could not reliably determine the server's fully qualified domain name" warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set Document Root
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

# 6.a Regenerate optimized Composer autoload now that app files are present
# This fixes issues where composer was run earlier (before copying app files)
# with --classmap-authoritative and the classmap didn't include application classes.
RUN composer dump-autoload --optimize --classmap-authoritative --no-interaction || true

# 7. Copy Frontend Assets (from Stage 1)
COPY --from=node_builder /app/public/build /var/www/html/public/build

# 8. Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# [FIX] Forcefully disable conflicting MPMs and enable mpm_prefork
# We run this late in the build process to ensure no other steps have re-enabled them.
# We manually remove the symlinks to be absolutely sure.
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_event.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.conf \
    && a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork

# 9. Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# [FIX] Apache defaults to Port 80.
# If you expose 8000 but Apache is on 80, Railway/Deployment will fail because it can't connect.
EXPOSE 80

# 10. Run Entrypoint
ENTRYPOINT ["entrypoint.sh"]