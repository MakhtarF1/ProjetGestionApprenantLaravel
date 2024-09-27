FROM php:8.3-fpm

# Installer les dépendances
RUN apt-get update && \
    apt-get install -y libxml2-dev git unzip && \
    docker-php-ext-install xml

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer Node.js et npm
RUN apt-get install -y nodejs npm

# Définir le répertoire de travail
WORKDIR /app
COPY . .

# Autres configurations et étapes d'installation
CMD php artisan serve --host=0.0.0.0 --port=$PORT