FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    curl \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl

# Enable mod_rewrite
RUN a2enmod rewrite

COPY ./ /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80 