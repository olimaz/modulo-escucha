#!/bin/bash
# Utiliza el nombre del archivo en lugar de un for
file=$1
echo  "---------- Proceso de convertir a mp3 liviano y cifrar un archivo para "  $file
# echo "Generar nuevo mp3 :" $1
echo ffmpeg -y -i "$file" -ac1 -b:a 64k "${file%.*}_64k.mp3" -b:a 64k
ffmpeg -y -i "$file" -ac 1 -b:a 64k "${file%.*}_64k.mp3"
echo "Fin del proceso de conversion a mp3"
echo "----------------"
echo "Cifrando archivo"
echo gpg --batch -v --yes --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co   "${i%.*}_64k.mp3"
gpg --batch -v --yes --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co   "${file%.*}_64k.mp3"
echo "Fin del proceso."
echo "---------"
ls -lhtr  "${file%.*}"*
#echo "---------"



