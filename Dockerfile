FROM php:8.2-apache

# Apache設定：Laravelのpublicディレクトリをドキュメントルートに
ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# 必要パッケージ
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    zip \
    libonig-dev \
    curl

# PHP拡張
RUN docker-php-ext-install pdo pdo_mysql zip mbstring

# Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# アプリコピー
COPY . /var/www
WORKDIR /var/www

# Composer install
RUN composer install --no-dev --optimize-autoloader

# Laravelのパーミッション
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
