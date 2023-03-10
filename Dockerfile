# Select php image
FROM php:8.0-apache

# Apache configuration
COPY apache2.conf /etc/apache2/conf-enabled/
COPY php_ini_override.ini /usr/local/etc/php/conf.d/

# Installing libraries
RUN apt-get update
RUN apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    openssl

# Installing php extensions
RUN docker-php-ext-install gd zip intl bcmath
RUN docker-php-ext-install pdo pdo_mysql

# Installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enabling mod_rewrite
RUN a2enmod rewrite

# Selecting document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -i -e 's/\/var\/www\/html/${APACHE_DOCUMENT_ROOT}/g' /etc/apache2/sites-available/000-default.conf

# Changing files ownership and current user
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data
USER www-data