#!/bin/bash
file=$1
echo  "---------- Proceso de convertir a mp3 liviano y cifrar un archivo. "
echo "Generar nuevo mp3 :" $1
echo ffmpeg -y -i "$file" -ac 1 -b:a 64k "${file%.*}_64k.mp3"
ffmpeg -y -i "$file" -ac 1 -b:a 64k "${file%.*}_64k.mp3"
echo "----------------"
echo "Fin del proceso de conversion a mp3"
echo "----------------"
echo "Cifrando archivo"
gpg --batch -v --yes --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient $
echo "Fin del proceso."
chown www-data:www-data "${file%.*}"*
chmod 755 "${file%.*}"*
echo "---------"
ls -lhtr  "${file%.*}"*
echo "---------"
