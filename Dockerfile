FROM php:8.2-apache

# Apache設定：Laravelのpublicディレクトリをドキュメントルートに
ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# 必要パッケージのインストール
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    zip \
    libonig-dev \
    curl

# PHP拡張モジュールのインストール
RUN docker-php-ext-install pdo pdo_mysql zip mbstring

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# アプリケーションのコピー
COPY . /var/www
WORKDIR /var/www

# Laravelの依存パッケージをインストール
RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader; fi

# Laravelのストレージ・キャッシュディレクトリにパーミッション付与
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
