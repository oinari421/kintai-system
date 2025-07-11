FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    zip \
    libonig-dev \
    curl \
    libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql pgsql zip mbstring

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

COPY . /var/www
WORKDIR /var/www

COPY .env.production .env





RUN composer install --no-dev --optimize-autoloader \
 && php artisan config:clear \
 && php artisan config:cache

RUN mkdir -p storage/logs \
 && touch storage/logs/laravel.log \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD bash -c " \
    php artisan migrate --force && \
    tail -f storage/logs/laravel.log & \
    apache2-foreground"

