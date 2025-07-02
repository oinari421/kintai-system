FROM php:8.2-fpm

# 必要パッケージ
RUN apt-get update && apt-get install -y \
    nginx \
    curl \
    unzip \
    git \
    libzip-dev \
    libonig-dev \
    supervisor

# PHP拡張
RUN docker-php-ext-install pdo pdo_mysql zip mbstring

# Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Nginx設定ファイルをコピー
COPY default.conf /etc/nginx/sites-available/default

# Supervisor設定ファイル
COPY start.sh /start.sh
RUN chmod +x /start.sh

# 作業ディレクトリ設定（RenderがGit cloneしてくれる）
WORKDIR /var/www

# Composer依存をインストール
RUN composer install --no-dev --optimize-autoloader

# Laravelパーミッション
RUN chmod -R 775 storage bootstrap/cache

# ポート指定（RenderはPORTという環境変数を渡す）
ENV PORT=80
EXPOSE 80

CMD ["/start.sh"]
