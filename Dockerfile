# Multi-stage Dockerfile for Laravel + Vite
# Stage 1: Build frontend assets with Node
FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources/js resources/js
COPY resources/css resources/css
RUN npm ci --silent
RUN npm run build

# Stage 2: Install PHP dependencies with Composer
FROM composer:2 AS composer_builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Stage 3: Runtime image with PHP-FPM and Nginx
FROM php:8.2-fpm-alpine
ARG APP_USER=www-data
WORKDIR /var/www/html

# Install system packages and PHP extensions
RUN apk add --no-cache nginx supervisor libzip-dev oniguruma-dev curl bash tzdata \
    && docker-php-ext-install pdo_mysql mbstring bcmath zip

# Create directories and set permissions
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache /run/php \
    && chown -R ${APP_USER}:${APP_USER} /var/www/html

# Copy composer dependencies and app skeleton
COPY --from=composer_builder /app/vendor ./vendor
COPY --from=composer_builder /app/composer.json ./composer.json

# Copy built assets from node_builder
# Vite commonly outputs to `public/build` or `dist`; adjust if your project uses a different path
COPY --from=node_builder /app/dist ./public/build

# Copy application source
COPY . .

# Remove default nginx config and add our config
RUN rm -f /etc/nginx/conf.d/default.conf
COPY docker/nginx.conf /etc/nginx/conf.d/app.conf

# Copy supervisord config
COPY docker/supervisord.conf /etc/supervisord.conf

# Fix permissions for storage and cache
RUN chown -R ${APP_USER}:${APP_USER} /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
