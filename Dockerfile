FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    zip \
    libonig-dev \
    curl

RUN docker-php-ext-install pdo pdo_mysql zip mbstring

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# ...
COPY . /var/www
WORKDIR /var/www

# Create SQLite file
RUN touch database/database.sqlite \
 && chmod 666 database/database.sqlite

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy and generate .env, migrate
RUN cp .env.example .env \
 && php artisan key:generate \
 && php artisan migrate --force

# Set permissions and prepare logs
RUN mkdir -p storage/logs \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache storage/logs

EXPOSE 80
CMD tail -f storage/logs/laravel.log & apache2-foreground
