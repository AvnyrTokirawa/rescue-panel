#!/bin/sh
echo 'starting app ... '
cd /var/www

echo 'caching data ... '
php artisan cache:clear
php artisan route:cache
php artisan event:cache
php artisan storage:link
php artisan key:generate

echo 'building front ...'
yarn build

echo 'start worker & nginx... '
pm2 start ./queueworker.yml
nginx -t && service nginx restart

echo 'launch '
/usr/local/sbin/php-fpm -R