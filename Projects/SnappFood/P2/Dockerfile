FROM php:8.2-fpm
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libpng-dev \
    libpq-dev

RUN docker-php-ext-install pdo mbstring zip bcmath exif pcntl xml curl gd opcache pgsql pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . .
RUN composer install --no-scripts --no-autoloader --prefer-dist --no-dev --working-dir=/var/www/html
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R ug+rwx storage bootstrap/cache

EXPOSE 9000
EXPOSE 9001
CMD ["php-fpm"]
