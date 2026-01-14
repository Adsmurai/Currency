FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    curl \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    unzip

RUN docker-php-ext-install \
    xml \
    bcmath \
    mbstring \
    zip

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

WORKDIR /app