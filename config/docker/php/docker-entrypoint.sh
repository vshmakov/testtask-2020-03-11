#!/bin/sh
composer install --no-scripts
bin/console doctrine:migrations:migrate -n
php-fpm
