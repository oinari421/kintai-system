FROM php:8.2-fpm

# MySQL に接続するための拡張をインストール
RUN docker-php-ext-install pdo pdo_mysql

# Composer も一緒に入れる（なければ）
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリ
WORKDIR /var/www
