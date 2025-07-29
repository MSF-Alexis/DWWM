# Utiliser une image de base avec PHP et Apache
FROM php:8.3-apache

# Activer le module Apache rewrite (pour les liens symboliques)
RUN a2enmod rewrite

# Créer un répertoire pour l'application
RUN mkdir -p /var/www/html

# Créer un lien symbolique vers le dossier monté depuis la machine hôte
RUN ln -s /app /var/www/html

# Définir les permissions pour le dossier (facultatif)
RUN chown -R www-data:www-data /var/www/html

# Installer des dépendances supplémentaires
RUN apt-get update -qq && \
    apt-get install -qy \
    git \
    gnupg \
    unzip \
    zip

# Installer des extensions PHP nécessaires
RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql

# Copier un fichier de configuration PHP personnalisé
COPY DOCKER_CONF/php.ini /usr/local/etc/php/conf.d/app.ini

# Configuration Apache pour permettre l'accès au dossier /var/www/html/app
RUN echo "<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/app.conf

RUN a2enconf app

# Exposer le port 80
EXPOSE 80

# Démarrer Apache en premier plan
CMD ["apache2-foreground"]