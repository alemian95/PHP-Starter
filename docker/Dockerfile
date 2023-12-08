# Select php image
FROM php:8.2-apache

# Installing libraries
RUN apt-get update
RUN apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    zip \
    unzip \
    openssl

# Installing supervisor
RUN apt-get update && apt-get install -y supervisor

# Installing php extensions
RUN docker-php-ext-install gd zip intl bcmath
RUN docker-php-ext-install pdo pdo_mysql

# Installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enabling mod_rewrite
RUN a2enmod rewrite

# Set document root to public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable https
# RUN apt-get install -y ssl-cert
# RUN a2enmod ssl headers
# RUN a2ensite default-ssl.conf

# Apache configuration
COPY apache2.conf /etc/apache2/conf-enabled/
COPY php_ini_override.ini /usr/local/etc/php/conf.d/

# Changing files ownership and current user
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

# Set permissions for SSL files
# RUN chown -R www-data:www-data /etc/ssl/private
# RUN chmod -R 700 /etc/ssl/private
