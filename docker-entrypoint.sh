#!/bin/bash
set -e

# Exécutez les migrations de la base de données
php artisan migrate --force

# Démarrez le serveur PHP-FPM
php-fpm
