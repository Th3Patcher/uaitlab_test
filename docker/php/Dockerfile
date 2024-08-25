FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get -y update && apt-get upgrade -y && \
    apt-get install --quiet --yes --no-install-recommends \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nano \
    && docker-php-ext-install zip gd pdo pdo_mysql zip exif pcntl mbstring \
    && pecl install xdebug-3.2.0 \
    && docker-php-ext-enable xdebug pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd --gid 1000 appuser \
    && useradd --uid 1000 -g appuser \
    -G www-data,root --shell /bin/bash \
    --create-home appuser

COPY conf.d/* $PHP_INI_DIR/conf.d

USER appuser