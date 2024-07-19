FROM php:7.4-fpm

WORKDIR /var/www/html

RUN apt-get update
RUN apt-get install -y curl
RUN apt-get install -y nginx

RUN docker-php-ext-install -j$(nproc) pdo
RUN docker-php-ext-install -j$(nproc) pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json ./

RUN composer install --no-autoloader

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=root:root . .

RUN composer dump-autoload --optimize

EXPOSE 5050

COPY nginx.conf /etc/nginx/conf.d/default.conf

CMD nginx -g "daemon off;" & php-fpm
