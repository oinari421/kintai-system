FROM php:8.2-apache

# ドキュメントルートを /var/www/public に設定
ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Apache モジュール設定
RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    zip \
    libonig-dev \
    curl \
    libpq-dev

# PHP拡張モジュールをインストール（PostgreSQL含む）
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip mbstring

# Composer をインストール
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# アプリケーションコードをコピー
COPY . /var/www
WORKDIR /var/www

# 権限設定
RUN mkdir -p storage/logs \
 && touch storage/logs/laravel.log \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# Composer依存をインストール（本番用）
RUN composer install --no-dev --optimize-autoloader

# .env は使わず、Renderの環境変数に任せる！
RUN php artisan key:generate \
 && php artisan config:clear

EXPOSE 80

CMD bash -c " \
    php artisan migrate --force && \
    tail -f storage/logs/laravel.log & \
    apache2-foreground"
