#!/usr/bin/sh
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin

echo "----INICIO DEL PROCESO---"
date
days="$(date +'%Y%m%d_%H%M')"
echo "-----Verificación de audios no mp3------"
for x in wav pcm wma acc aac mp4 m4a; do
for i in /var/www/html/expedientes/storage/app/public/*/*."${x}"; do
   filename_mp3="${i%%.*}"_64k.mp3
   echo ${i}
   if test -f ${filename_mp3}; #Verifica si existe un archivo mp3
   then
     duration_wav=$(ffmpeg -i $i 2>&1 | grep Duration | cut -d ' ' -f 4 | sed s/,//)
     cwav=$(echo ${duration_wav} | cut -f1 -d ".")
     duration_mp3=$(ffmpeg -i $filename_mp3 2>&1 | grep Duration | cut -d ' ' -f 4 | sed s/,//)
     cmp3=$(echo ${duration_mp3} | cut -f1 -d ".")
     d1=$(date -d "$cwav" +%s)
     d2=$(date -d "$cmp3" +%s)
     diff=$(echo $(($d1 - $d2)))
     if [ ${diff} -gt 100 ] #Si existe el mp3, compara las longitudes entre original y convertido. Puede no tolerarse mayor a 70
        then
            echo Error: ${cwav} no igual a ${cmp3}. Ubicación: $i
            echo "Eliminando archivo erroneo"
            rm "${i%.*}_64k.mp3"
            echo "Corrigiendo..." "$i" 
            ffmpeg -loglevel error -y -i "$i" -ac 1 -b:a 64k  "${i%.*}_64k.mp3" 2>> /root/logs/${days}_fixing_audio_to_mp3.log
            echo "Eliminando encripción anterior..."
            rm "${i%.*}_64k.mp3.gpg"
            echo "Encriptando..."
            gpg --batch --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co "${i%.*}_64k.mp3" >/dev/null ;
       else
        #Si no hay problema con la longitud, revisa si el mp3 fue encriptado
        filename_gpg="${i%%.*}"_64k.mp3.gpg
        if test -f ${filename_gpg};
        then
            echo "Ya está encriptado "${filename_mp3}""
        else
            echo "No existía gpg para "${filename_mp3}". Encriptando..."
            gpg --batch --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co "${i%.*}_64k.mp3" >/dev/null ;
        fi
   fi
 else
     #Si no existe el mp3, lo convierte y lo encripta
     echo "${filename_mp3} no existe. Convirtiendo..."
     ffmpeg -loglevel error -i "$i" -ac 1 -b:a 64k  "${i%.*}_64k.mp3" 2>> /root/logs/${days}_converting_audio_to_mp3.log
     echo "Eliminando encripción (por si existe)"
     rm "${i%.*}_64k.mp3.gpg"
     echo "Encriptando..."
     gpg --batch --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co "${i%.*}_64k.mp3" >/dev/null 
   fi
done

echo "----- Fin de verificación de audios no MP3-------"

for j in $(find /var/www/html/expedientes/storage/app/public/ ! -name '*_64k*' -name '*.mp3'); do
   #Para archivos mp3(que no se convierten), solo se encriptará si no existe
   echo "Verificación de audios mp3"
   filename_gpg="${j%%.*}".mp3.gpg
   echo $filename_gpg
   if test -f ${filename_gpg};
      then
        echo "Ya está encriptado "${j}""
      else
        echo "No existía gpg para "${j}". Encriptando..."
        gpg --batch --homedir /var/www/html/expedientes/.gnupg --trust-model always --encrypt --recipient transcripcion@comisiondelaverdad.co "$j" >/dev/null ;
   fi
done
done

chown www-data:www-data /var/www/html/expedientes/storage/app/public/* -Rf
chmod 755 /var/www/html/expedientes/storage/app/public/* -Rf
df -h .
date
echo "----FIN DEL PROCESO---"
