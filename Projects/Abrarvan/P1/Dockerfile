FROM php:8.1-cli

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y git zlib1g-dev libzip-dev unzip

RUN pecl install redis && docker-php-ext-install zip mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql redis

WORKDIR /Projects/

COPY ./ ./

RUN composer install

CMD [ "php", "artisan", "serve", "--host", "0.0.0.0" ]
