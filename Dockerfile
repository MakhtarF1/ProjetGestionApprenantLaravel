FROM php:8.3-fpm

# Installer les dépendances système nécessaires
RUN apt-get update && \
    apt-get install -y libxml2-dev git unzip && \
    docker-php-ext-install xml

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer Node.js et npm
RUN apt-get install -y nodejs npm

# Définir le répertoire de travail
WORKDIR /app

# Copier les fichiers composer.json et composer.lock pour installer les dépendances
COPY composer.json composer.lock ./

# Installer les dépendances de l'application
RUN composer install --no-dev --optimize-autoloader

# Copier le reste des fichiers de l'application
COPY . .

# Exposer le port pour le serveur
EXPOSE 8000

# Commande pour exécuter l'application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
