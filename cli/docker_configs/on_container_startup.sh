#!/bin/sh

cd /var/www/html

APP_ENV=prod COMPOSER_HOME=/root /usr/bin/composer install --no-cache --optimize-autoloader --no-dev \
    && chown -R www-data:www-data ./var