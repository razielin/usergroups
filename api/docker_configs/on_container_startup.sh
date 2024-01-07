#!/bin/sh

cd /var/www/html

php bin/console doctrine:migrations:migrate --no-interaction --env=prod \
    && chown -R www-data:www-data ./var