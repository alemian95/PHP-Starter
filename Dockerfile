FROM php:8.0-apache

COPY apache2.conf /etc/apache2/conf-enabled/
COPY php_ini_override.ini /usr/local/etc/php/conf.d/

RUN apt-get update
RUN apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpng-dev

RUN docker-php-ext-install gd zip intl bcmath
RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -i -e 's/\/var\/www\/html/\/var\/www\/html\/public/g' /etc/apache2/sites-available/000-default.conf

ARG user_id=1000
RUN usermod -u $user_id www-data