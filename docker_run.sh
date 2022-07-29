#!/bin/bash

cd /var/www; php artisan config:cache
php artisan storage:link

# add cron job into cronfile
echo "* * * * * cd /var/www && php artisan schedule:run >> /dev/null 2>&1" >> cronfile
# install cron job
crontab cronfile
# rm tmp file
rm cronfile

env >> /var/www/.env
php-fpm7.2 -D
cron -f &
nginx -g "daemon off;"