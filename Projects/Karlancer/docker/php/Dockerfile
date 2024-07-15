FROM php:8.2-fpm

WORKDIR /var/www/html

ARG user

#### system dependencies ####
RUN apt-get update --fix-missing -y && apt-get upgrade -y && apt-get install -y \
    git \
    curl \
    libpng-dev \
    zlib1g-dev \
    libonig-dev \
    libssl-dev \
    libzip-dev  \
    build-essential \
    zip \
    unzip \
    nano \
    htop \
    procps

RUN apt-get install -y libcurl4-openssl-dev
RUN docker-php-ext-install curl

#### SSL ####
RUN apt-get install -y --no-install-recommends openssl

##### PHP extensions ####
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

#####  MYSQL client #####
RUN apt-get install -y default-mysql-client

#### System user to run composer and artisan ####
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN mkdir /var/www/.composer \
    && chown $user:$user /var/www/.composer

COPY docker-fpm.ini /usr/local/etc/php/conf.d/docker-fpm.ini

#### redis ####
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis
