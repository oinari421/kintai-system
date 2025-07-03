#!/bin/bash

cd /var/www

echo "✅ Start script started..."

# .env がなければ .env.example からコピー（Renderでは必要になる場合あり）
if [ ! -f .env ]; then
    echo "⚠️ .env ファイルが見つかりません。コピーします..."
    cp .env.example .env
fi

# APP_KEY が未設定なら生成
if ! grep -q "APP_KEY=base64" .env; then
    echo "🔑 アプリキーを生成します..."
    php artisan key:generate
fi

# キャッシュクリア & 再キャッシュ
echo "♻️ キャッシュを再生成中..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# マイグレーション実行
echo "📦 データベースマイグレーションを実行..."
php artisan migrate --force

# PHP-FPM 起動（バックグラウンド）
echo "🚀 PHP-FPM 起動中..."
php-fpm -D

# Nginx 起動（フォアグラウンド）
echo "🌐 Nginx 起動中..."
nginx -g "daemon off;"

npm install
npm run build
