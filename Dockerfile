# Verwende ein offizielles PHP-Image als Basis
FROM php:8.1-apache

# Installiere Systemabhängigkeiten und PHP-Erweiterungen
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    mariadb-client \
    libmariadb-dev \
    python3 \
    python3-pip \
    python3-venv && \
    docker-php-ext-install pdo_mysql

# Installiere Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@latest

# Erstelle und aktiviere eine Python-virtuelle Umgebung
RUN python3 -m venv /venv && \
    /venv/bin/pip install --upgrade pip && \
    /venv/bin/pip install webuntis

# Kopiere den aktuellen Inhalt in den Container
COPY . /var/www/html

# Setze das Arbeitsverzeichnis
WORKDIR /var/www/html

# Aktivieren des Apache-Moduls rewrite
RUN a2enmod rewrite

# Setze den Pfad für Python und Pip auf die virtuelle Umgebung
ENV PATH="/venv/bin:$PATH"

# Setze den Arbeitsordner und starte den Container
CMD ["apache2-foreground"]
