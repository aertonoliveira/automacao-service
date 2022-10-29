FROM php:7.3.23-fpm

RUN apt-get update && apt-get install -y --allow-unauthenticated \
    gnupg \
    libcurl4-openssl-dev \
    libzip-dev \
    git \
    sendmail \
    libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql \
    && docker-php-ext-install tokenizer \
    && docker-php-ext-install curl \
#    && docker-php-ext-install sodium \
    && docker-php-ext-install zip;

RUN cd ~ \
    && curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer;

WORKDIR /usr/share/nginx/html
