FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

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

COPY . /var/www
WORKDIR /var/www

RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader; else echo "composer.json not found"; exit 1; fi

# Laravelのパーミッション設定
RUN mkdir -p storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache


# 環境ファイルを .env にコピー（ビルド中は必要）
RUN if [ ! -f .env ]; then cp .env.example .env; fi

EXPOSE 80
CMD php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan key:generate && \
    apache2-foreground
