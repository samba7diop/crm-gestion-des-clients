
FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install zip pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer config -g process-timeout 2000

RUN composer config -g github-protocols https

RUN COMPOSER_MEMORY_LIMIT=-1 composer install \
    --prefer-dist \
    --no-interaction \
    --optimize-autoloader

# Render fournit le port via la variable d'env PORT
# -t public : document root
# public/index.php : router pour que / soit servi par Laravel
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8000} -t public public/index.php"]




# # Image PHP avec Apache
# FROM php:8.2-apache

# # Installer dépendances système
# RUN apt-get update && apt-get install -y \
#     git \
#     unzip \
#     zip \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     libzip-dev \
#     libpq-dev

# # Installer extensions PHP nécessaires
# RUN docker-php-ext-install \
#     pdo \
#     pdo_mysql \
#     pdo_pgsql \
#     mbstring \
#     exif \
#     pcntl \
#     bcmath \
#     gd \
#     zip

# # Activer mod_rewrite Apache
# RUN a2enmod rewrite

# # Installer Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Définir le dossier de travail
# WORKDIR /var/www

# # Copier les fichiers du projet
# COPY . .

# # Installer dépendances Laravel
# RUN composer install 
# #--no-dev --optimize-autoloader

# # Permissions Laravel
# RUN chown -R www-data:www-data /var/www/storage
# RUN chown -R www-data:www-data /var/www/bootstrap/cache

# # Config Apache pour pointer vers public/
# ENV APACHE_DOCUMENT_ROOT /var/www/public

# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
#     /etc/apache2/sites-available/*.conf

# RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
#     /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# # Optimisations Laravel
# RUN php artisan config:cache || true
# RUN php artisan route:cache || true
# RUN php artisan view:cache || true

# # Port Render
# EXPOSE 10000

# CMD sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf \
#     /etc/apache2/sites-enabled/000-default.conf && \
#     apache2-foreground