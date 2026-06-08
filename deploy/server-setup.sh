#!/usr/bin/env bash
set -euo pipefail

export DEBIAN_FRONTEND=noninteractive

sudo apt-get update -qq
sudo apt-get install -y -qq \
    nginx \
    mysql-server \
    php-fpm php-cli \
    php-mysql php-mbstring php-xml php-curl php-zip php-bcmath php-intl php-gd \
    unzip git curl

PHP_VERSION=$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')
PHP_FPM_SOCK="/var/run/php/php${PHP_VERSION}-fpm.sock"

if ! command -v composer >/dev/null 2>&1; then
    curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
fi

DB_PASS="${DB_PASS:-$(openssl rand -base64 24 | tr -d '/+=' | head -c 24)}"

sudo mysql -e "CREATE DATABASE IF NOT EXISTS convertlane CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER IF NOT EXISTS 'convertlane'@'localhost' IDENTIFIED BY '${DB_PASS}';"
sudo mysql -e "GRANT ALL PRIVILEGES ON convertlane.* TO 'convertlane'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

sudo mkdir -p /var/www/convertlane
sudo chown -R ubuntu:www-data /var/www/convertlane

echo "${DB_PASS}" | sudo tee /root/convertlane-db-pass.txt >/dev/null
sudo chmod 600 /root/convertlane-db-pass.txt

sudo tee /etc/nginx/sites-available/convertlane >/dev/null <<NGINX
server {
    listen 80 default_server;
    listen [::]:80 default_server;
    server_name convertlane.co.uk www.convertlane.co.uk _;
    root /var/www/convertlane/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:${PHP_FPM_SOCK};
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
NGINX

sudo ln -sf /etc/nginx/sites-available/convertlane /etc/nginx/sites-enabled/convertlane
sudo rm -f /etc/nginx/sites-enabled/default

sudo nginx -t
sudo systemctl enable --now nginx php${PHP_VERSION}-fpm mysql
sudo systemctl restart nginx php${PHP_VERSION}-fpm mysql

echo "SETUP_OK PHP=${PHP_VERSION} DB_PASS_FILE=/root/convertlane-db-pass.txt"
