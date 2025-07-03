FROM php:8.2-apache

# Laravelのpublicをドキュメントルートに変更
ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# .htaccessを有効にする
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# パッケージインストール
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

# ソースコード配置
COPY . /var/www
WORKDIR /var/www

# Composer install
RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader; else echo "composer.json not found"; exit 1; fi

# Laravelパーミッション
RUN mkdir -p storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# .envがなければ作成
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# ポート公開
EXPOSE 80

# Laravel起動処理
CMD php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan key:generate && \
    apache2-foreground
