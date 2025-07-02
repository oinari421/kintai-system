FROM php:8.2-apache

# 必要パッケージ
RUN apt-get update && apt-get install -y \
    curl unzip git libzip-dev libonig-dev

# PHP拡張
RUN docker-php-ext-install pdo pdo_mysql zip mbstring

# Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Apacheの設定
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# .htaccessを有効にする
RUN a2enmod rewrite

# 作業ディレクトリ
WORKDIR /var/www

# Composer依存をインストール
RUN composer install --no-dev --optimize-autoloader

# Laravelパーミッション
RUN chmod -R 775 storage bootstrap/cache

# ポート指定
ENV PORT=80
EXPOSE 80

CMD ["apache2-foreground"]
