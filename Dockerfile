FROM php:8.2-apache

# Installa estensione per PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Imposta la working directory
WORKDIR /var/www/html
