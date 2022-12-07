#!/bin/bash

que_tiempo_es_mayor() {
 
 t1=$1 #tiempo 1
 t2=$2 #tiempo 2

 if [ "$t1" -gt "$t2" ]; then
    echo 1
 else

    if [ "$t1" -eq "$t2" ]; then
        echo 0
    else
       echo 2
    fi
 fi

}

restar_tiempo() {
 t1=$1 ##hh1
 t2=$2 ##mm1
 t3=$3 ##ss1
 t4=$4 ##hh2
 t5=$5 ##mm1
 t6=$6 ##ss1
 d_ss=0

 ##Resta de segundos

 if [ 1 -eq $(echo "($t3 - $t6) > 0" | bc) ]; then
    d_ss=$(echo "$t3-$t6"|bc -l) 
 else
    #tmp1=${#t3}
    #tmp2=${#t6}
    if [ 1 -eq $(echo "($t6 - $t3) > 0" | bc) ]; then
       
       tmp_ss=$(echo "$t3+60"|bc -l)
       t2=$(($t2-1)) 
       d_ss=$(echo "$tmp_ss-$t6"|bc -l)
    else
       d_ss=0
    fi       
 fi

 ##Resta de minutos
 band2=$(que_tiempo_es_mayor "$t2" "$t5")
 if [ "$band2" -eq "1" ]; then
    d_mm=$(($t2-$t5))
 else
    if [ "$band2" -eq "0" ]; then
       d_mm=0
    else
       tmp_mm=$(($t2+60))
       t1=$(($t1-1)) 
       d_mm=$(($tmp_mm-$t5))
    fi       
 fi

 ##Resta de horas 
 d_hh=$(($t1-$t4))

 echo "$d_hh:$d_mm:$d_ss"
}

comparar_archivo() {

 log=$5
 nombre=$2 	## param 2:= nombre archivo
 extension=$3 	## param 4:= extension archivo
 original=$4 	## param 4:= archivo orignal mp3

 nombre3="${nombre}_64k.mp3"

 for f in "$1"/* 
   do
    if [ -f $f ]; then
       
       filename2="$(basename -- "$f")"
       nombre2="${filename2%.*}"
       extension2="${filename2##*.}"
      
        if [ $nombre3 = $filename2 ]; then
	
      duracion=$(ffmpeg -i $original 2>&1 | grep Duration | cut -d ' ' -f 4 | sed s/,//)
      duracion2=$(ffmpeg -i $f 2>&1 | grep Duration | cut -d ' ' -f 4 | sed s/,//)
	    
            
            temp_1=${duracion#*:}
            hh_1=${duracion%%:*}            
            mm_1=${temp_1%%:*}
            ss_1=${temp_1#*:}
            
            temp_2=${duracion2#*:}
            hh_2=${duracion2%%:*}
            mm_2=${temp_2%%:*}
            ss_2=${temp_2#*:}

            dt=0

            #identifica duracion mayor
            result=$(que_tiempo_es_mayor "$hh_1" "$hh_2")
            
            if [ "$result" -eq "0" ]; then

               result=$(que_tiempo_es_mayor "$mm_1" "$mm_2")
               
	       if [ "$result" -eq "1" ]; then

                   #echo "T1 es mayor"
                   dt=$(restar_tiempo "$hh_1" "$mm_1" "$ss_1" "$hh_2" "$mm_2" "$ss_2")
               else

	          if [ "$result" -eq "2" ]; then
                      
                     dt=$(restar_tiempo "$hh_2" "$mm_2" "$ss_2" "$hh_1" "$mm_1" "$ss_1")
                  else
		      ss_1=${#ss_1}
                      ss_2=${#ss_2}
                      if [ "$ss_1" -eq "$ss_2" ]; then
                         #echo "T1 y T2 son iguales"
                         dt=0
                      else

                          if [ 1 -eq $(echo "($ss_1 - $ss_2) > 0" | bc) ]; then

                           #echo "T1 es mayor"
			   dt=$(restar_tiempo "$hh_1" "$mm_1" "$ss_1" "$hh_2" "$mm_2" "$ss_2")
                         else
                        
                           #echo "T2 es mayor"
                           dt=$(restar_tiempo "$hh_2" "$mm_2" "$ss_2" "$hh_1" "$mm_1" "$ss_1")
                         fi
                      fi
                      
                  fi
               fi
              
            else

               if ["$result" -eq 1]; then
                   #echo "T1 es mayor"
                   dt=$(restar_tiempo "$hh_1" "$mm_1" "$ss_1" "$hh_2" "$mm_2" "$ss_2")
               else
                   #echo "T2 es mayor"
                   dt=$(restar_tiempo "$hh_2" "$mm_2" "$ss_2" "$hh_1" "$mm_1" "$ss_1")
               fi
            fi
            
            
                       
            if [ "$duracion" = "$duracion2" ]; then

               temp1=1
               # echo "Igual duración - audio: $nombre" >> $log
               # echo "Ruta: $path" >> $log
               # echo "\n" >> $log

            else
                path=$(dirname "${f}")
                
                #echo "Diferente duración - audio: $nombre" >> $log
                echo "Ruta: $path/$nombre.$extension" >> $log
                #echo "T1: $temp_1" >> $log
                #echo "T2: $temp_2" >> $log
                #echo "Diferencia de tiempo: $dt" >> $log
                #echo "\n" >> $log
                 
            fi
	     
       fi
    fi
 done
 
}


directorio(){

 log=audios.txt
    for item in "$1"/* 
    do 
    
    if [ -d "$item" ]
    then 
	for file in "$item"/* 
 	do
		    
    	  ## valida si es un archivo
          if [ -f $file ]; then
                      
	      filename="$(basename -- "$file")"
	      nombre="${filename%.*}"
              extension="${filename##*.}"

              if [ $extension = "wav" ]; then

          	 subdir="${item}"
                 ## 1:subdir, 2:nombre, 3:extension, 4:file, 5:log
                 comparar_archivo "$subdir" "$nombre" "$extension" "$file" "$log"
              fi
    
          fi

	done

        directorio "$item"
    fi
    done
}

directorio "$1"
