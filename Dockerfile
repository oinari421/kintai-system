FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

# ←これを追加（警告解消）
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# 以下略...

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

RUN touch database/database.sqlite && chmod 666 database/database.sqlite

RUN composer install --no-dev --optimize-autoloader

RUN cp .env.example .env \
 && php artisan key:generate \
 && sed -i 's|DB_DATABASE=.*|DB_DATABASE=/var/www/database/database.sqlite|' .env \
 && php artisan config:clear

RUN mkdir -p storage/logs \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache storage/logs


EXPOSE 80

CMD bash -c " \
    echo 'Checking database file...'; \
    ls -l /var/www/database; \
    if [ ! -f database/database.sqlite ]; then \
        touch database/database.sqlite && chmod 666 database/database.sqlite; \
    fi && \
    php artisan migrate --force && \
    apache2-foreground"

