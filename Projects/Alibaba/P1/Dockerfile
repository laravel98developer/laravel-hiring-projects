FROM php:8.1-fpm

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        unzip \
        git \
        supervisor \
    && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html

ENV APP_NAME=Laravel
ENV APP_ENV=local
ENV APP_KEY="base64:z1xmmFMhnA+jZunDqxJBeEDQirtyeMRw7c5yhytgIHo="
ENV APP_DEBUG=true
ENV APP_URL=http://localhost

ENV LOG_CHANNEL=stack
ENV LOG_DEPRECATIONS_CHANNEL=null
ENV LOG_LEVEL=debug

ENV BROADCAST_DRIVER=log
ENV CACHE_DRIVER=file
ENV FILESYSTEM_DISK=local
ENV QUEUE_CONNECTION=sync
ENV SESSION_DRIVER=file
ENV SESSION_LIFETIME=120

ENV MEMCACHED_HOST=127.0.0.1

ENV REDIS_HOST=127.0.0.1
ENV REDIS_PASSWORD=null
ENV REDIS_PORT=6379




RUN composer install

RUN chown -R www-data:www-data storage bootstrap/cache


CMD ["php-fpm"]
