date

#rsync -r -t -v -e ssh  root@192.168.1.21:/var/www/html/expedientes/storage/app/public /var/www/html/expedientes/storage/app
rsync -r -t -v -e ssh  root@192.168.4.14:/mnt/san/www/html/expedientes/storage/app/public /var/www/html/expedientes/storage/app

chown www-data:www-data /var/www/html/expedientes/storage/app/public/* -Rf
chmod 755 /var/www/html/expedientes/storage/app/public/* -Rf

date
