FROM php:8.2-apache

# Apacheドキュメントルートを Laravel の public に設定
ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# mod_rewrite を有効にする
RUN a2enmod rewrite

# AllowOverride All を有効にする（.htaccess を使えるように）
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# 必要なパッケージのインストール
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    zip \
    libonig-dev \
    curl

# PHP拡張
RUN docker-php-ext-install pdo pdo_mysql zip mbstring

# Composerインストール
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# プロジェクトファイルをコピー
COPY . /var/www
WORKDIR /var/www

# ⬇ 追加！SQLiteファイルの作成
RUN touch database/database.sqlite && chmod 666 database/database.sqlite

# Composer依存をインストール
RUN composer install --no-dev --optimize-autoloader

# .env 作成と key 生成
RUN cp .env.example .env && \
    php artisan key:generate

# Laravelのパーミッション設定
RUN mkdir -p storage/logs && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache storage/logs


EXPOSE 80
CMD tail -f storage/logs/laravel.log & apache2-foreground

