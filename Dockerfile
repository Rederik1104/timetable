# Verwenden Sie ein offizielles PHP-Image als Basis
FROM php:8.1-apache

# Installieren Sie Systemabhängigkeiten und PHP-Erweiterungen
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    mariadb-client \
    && docker-php-ext-install pdo pdo_mysql

# Kopieren Sie den aktuellen Inhalt in den Container
COPY . /var/www/html

# Setzen Sie den Arbeitsverzeichnis
WORKDIR /var/www/html
