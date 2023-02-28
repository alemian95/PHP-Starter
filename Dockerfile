FROM php:8.0-apache
COPY apache2.conf /etc/apache2/conf-enabled/

RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    zip \
    libicu-dev \
    libonig-dev \
    libpq-dev \
    libxml2-dev \
    libpng-dev


RUN docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache \
    && docker-php-ext-install soap \
    && docker-php-ext-install gd

RUN docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install pdo_mysql

RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -i -e 's/\/var\/www\/html/\/var\/www\/html\/public/g' /etc/apache2/sites-available/000-default.conf

USER 1000:www-data