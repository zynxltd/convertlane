#!/usr/bin/env bash
set -euo pipefail

cd /var/www/convertlane

if [[ ! -f vendor/autoload.php ]]; then
    echo "Installing Composer dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction
fi

php artisan migrate --force --no-interaction
php artisan storage:link --force 2>/dev/null || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

sudo chown -R ubuntu:www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache

echo ""
echo "Done. Test: curl -I http://127.0.0.1/"
curl -sI http://127.0.0.1/ | head -5
