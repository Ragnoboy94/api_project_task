FROM php:8.2-apache


RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql \
    && a2enmod rewrite


COPY . /var/www/html


RUN chown -R www-data:www-data /var/www/html/var


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
