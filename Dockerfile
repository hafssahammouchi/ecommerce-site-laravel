# Laravel sur Render – PHP 8.2 + Apache
FROM php:8.2-apache

# Extensions PHP requises pour Laravel (MySQL + PostgreSQL pour Render)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    libpq-dev \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql pdo_pgsql zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Activer mod_rewrite pour Laravel
RUN a2enmod rewrite headers

# Vhost Laravel : document root = public, AllowOverride pour .htaccess
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

# Copier le projet (sans node_modules, .git, etc. grâce à .dockerignore)
COPY . .

# Installer les dépendances PHP (sans dev pour la prod)
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Droits Laravel (storage + bootstrap/cache)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Script de démarrage (migrations, cache, écoute sur PORT pour Render)
COPY docker/render-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/render-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/render-entrypoint.sh"]
