FROM php:8.1.8-fpm-alpine


LABEL Description="Base setup for IAmsterdam survey portal development."

RUN apk add --update --no-cache \
     --update linux-headers \
    $PHPIZE_DEPS \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    libpq-dev \
    imagemagick-dev \
    pcre-dev \
    npm \
    nodejs \
    && docker-php-ext-install pdo_mysql bcmath zip exif mysqli \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install -j "$(nproc)" gd \
    && pecl install redis xdebug \
    && docker-php-ext-enable redis xdebug


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && chmod +x /usr/bin/composer


WORKDIR /var/www/html
