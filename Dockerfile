FROM php:8.2-apache

# Estensioni per PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Working dir
WORKDIR /var/www/html

# Copia il codice dell’app dentro il container
COPY tesi/web/ /var/www/html/
