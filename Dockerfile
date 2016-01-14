# LessonComposer01
FROM php:7.0.2-fpm
MAINTAINER Max Kokorin <kokorin.max@gmail.com>

ENV APP_NAME LessonComposer01

COPY . /usr/src/"$APP_NAME"
WORKDIR /usr/src/"$APP_NAME"


RUN apt-get update && apt-get install -y \
        g++ \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \ 
        zlib1g-dev \
        libicu-dev \
        libmcrypt-dev \
        libpng12-dev \
        libpq-dev \
    && docker-php-ext-install iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-configure intl \
    && docker-php-ext-install gd \
    && docker-php-ext-install intl \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pgsql \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install zip \
    && docker-php-ext-install mbstring \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

EXPOSE 8080
# CMD ["php", "-S", "0.0.0.0:8080"]
