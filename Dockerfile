FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    git \
    unzip \
    curl
RUN docker-php-ext-install pdo pdo_pgsql zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

RUN curl -sL https://deb.nodesource.com/setup_24.x | bash -
RUN apt-get install -y nodejs

WORKDIR /app

COPY . .

RUN mkdir -p bootstrap/cache storage/framework/{cache,sessions,views} storage/logs

RUN mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/cache/data \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

RUN composer install
RUN npm ci
RUN npm run build
CMD ["bash", "-c", "php artisan migrate:refresh --seed --force && php artisan serve --host=0.0.0.0 --port=$PORT"]