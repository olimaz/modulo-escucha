#!/bin/bash

# Using argument expansion to capture all files provided as arguments.
# recibe el nombre de archivo como una ruta relativa (empezar por .)
# Ej de como utilizarlo: ./descarga.sh ./201905/5cd34b12d90d2.pdf
for FILE in ${@}
do
  if [[ ! -f $FILE ]]
  then
    echo "no existe"
    UBICA="${FILE#?}"
    echo $UBICA
    wget -O $FILE -t 1  -t 1 --timeout=3600  https://sim2.comisiondelaverdad.co/expedientes/public/storage$UBICA
  fi
done
