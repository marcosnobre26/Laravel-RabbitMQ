FROM composer:2 AS builder

WORKDIR /var/www/html

COPY . .

# Instala as extensões pcntl e posix
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install posix

# Instala as dependências do Composer
RUN composer install --ignore-platform-reqs --no-scripts

FROM php:8.0-fpm

WORKDIR /var/www/html

COPY --from=builder /var/www/html /var/www/html

CMD ["php-fpm"]
