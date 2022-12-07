echo "--------------------"
echo "----NUEVO PROCESO---"
date
echo "-- convirtiendo wav"
for i in /var/www/html/expedientes/storage/app/public/*/*.wav; do ffmpeg -loglevel panic -n -i "$i" -ac 1 -b:a 64k  "${i%.*}_64k.mp3"; done >>log_errors_wav_to_mp3_64k.log
echo "-- convirtiendo pcm"
for i in /var/www/html/expedientes/storage/app/public/*/*.pcm; do ffmpeg -loglevel panic -n -i "$i" -ac 1 -b:a 64k "${i%.*}_64k.mp3" ; done >>log_errors_wav_to_mp3_64k.log
echo "-- convirtiendo wma"
for i in /var/www/html/expedientes/storage/app/public/*/*.wma; do ffmpeg -loglevel panic -n -i "$i" -ac 1 -b:a 64k "${i%.*}_64k.mp3" ; done >>log_errors_wav_to_mp3_64k.log
echo "-- convirtiendo aac"
for i in /var/www/html/expedientes/storage/app/public/*/*.aac; do ffmpeg -loglevel panic -n -i "$i" -ac 1 -b:a 64k "${i%.*}_64k.mp3" ; done >>log_errors_wav_to_mp3_64k.log
echo "-- convirtiendo mp4"
for i in /var/www/html/expedientes/storage/app/public/*/*.mp4; do ffmpeg -loglevel panic -n -i "$i" -ac 1 -b:a 64k "${i%.*}_64k.mp3" ; done >>log_errors_wav_to_mp3_64k.log
echo "-- convirtiendo m4a"
for i in /var/www/html/expedientes/storage/app/public/*/*.m4a; do ffmpeg -loglevel panic -n -i "$i" -ac 1 -b:a 64k "${i%.*}_64k.mp3" ; done >>log_errors_wav_to_mp3_64k.log


echo "WAV:"
find /var/www/html/expedientes/storage/app/public/ -name "*.wav" | wc
echo  "_64k.mp3:"
find /var/www/html/expedientes/storage/app/public/ -name "*_64k.mp3" | wc
chown www-data:www-data /var/www/html/expedientes/storage/app/public/* -Rf
chmod 755 /var/www/html/expedientes/storage/app/public/* -Rf
df -h .
date
echo "----FIN DEL PROCESO---"

