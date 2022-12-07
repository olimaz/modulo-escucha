#!/bin/bash
# Script que hace backups en base a cronjobs
# Oliver M, 28-abr-19

BACKUP_DIR=/db_backup
DB_NAME=cev
TSTAMP=`date +%Y%m%d`
FILENAME=$BACKUP_DIR/$DB_NAME.sql.gz
Notify=2
Rotate=6
logfile=$BACKUP_DIR/backup.log
echo ".............Backup Script Running on $TSTAMP............" >> $logfile
echo $(date) >>$logfile
echo "................"
let i=$Rotate-1
if [ -f "$FILENAME.$Rotate" ];then
echo "$FILENAME.$Rotate Found,Deleting" >> $logfile
rm -rf $FILENAME.$Rotate
else
echo "$FILENAME.$Rotate Not Found, Not Removing" >> $logfile
fi
while [ $i -ge 1 ]
do
let j=$i+1;
if [ -f "$FILENAME.$i" ];then
echo $FILENAME.$i exists and is being moved to $FILENAME.$j >> $logfile
mv $FILENAME.$i $FILENAME.$j
else
echo $FILENAME.$i not found, not moving to $FILENAME.$j >> $logfile
fi
let i=$i-1
done
# pg_dump -d $DB_NAME -f $FILENAME.1
pg_dump -d $DB_NAME | gzip -9 > $FILENAME.1

echo "..........Backup Script Completed,Exiting Now.$TSTAMP........." >> $logfile
echo $(date) >>$logfile
echo "................"

if [ $Notify == 1 ];then
SUBJECT="Backup terminado en:`hostname`"
ADMIN="oliver.mazariegos@comisiondelaverdad.co"
function message {
echo -e "Hola,\n"
echo -e "..........................................................\n"
echo -e "Ya estuvo el backup de la base de datos de:`hostname`\n"
echo -e "Date-Time:`date`\n"
echo -e "--------------------------------------------------------\n"
}
message|mail -s "$SUBJECT" "$ADMIN"
fi
