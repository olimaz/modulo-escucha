
date
df -h .
for i in /var/www/html/expedientes/storage/app/public/*/*.mp3; do  gpg --batch --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co   "$i" >/dev/null ; done 
for i in /var/www/html/expedientes/storage/app/public/*/*.m4a; do  gpg --batch --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co   "$i" >/dev/null ; done 
for i in /var/www/html/expedientes/storage/app/public/*/*.pcm; do  gpg --batch --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co   "$i" >/dev/null ; done 
for i in /var/www/html/expedientes/storage/app/public/*/*.wma; do  gpg --batch --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co   "$i" >/dev/null ; done 
for i in /var/www/html/expedientes/storage/app/public/*/*.aac; do  gpg --batch --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co   "$i" >/dev/null ; done 
for i in /var/www/html/expedientes/storage/app/public/*/*.mp4; do  gpg --batch --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co   "$i" >/dev/null ; done 
chown www-data:www-data /var/www/html/expedientes/storage/app/public/* -Rf
chmod 755 /var/www/html/expedientes/storage/app/public/* -Rf
date
