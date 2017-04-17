#cd /var/www/adminwebmail
php bin/console cache:clear --env=prod --no-debug
#chmod g+rw /var/www/adminwebmail/ -R
#chown www-data:www-data /var/www/adminwebmail/ -R
php bin/console doctrine:schema:update --dump-sql
#php bin/console doctrine:schema:update --force --full-database
