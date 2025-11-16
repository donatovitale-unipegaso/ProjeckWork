#!/bin/bash
 
CLIENTE=$1
PRODOTTO=$2
AMBIENTE=$3
DATABASE=""
UTENZA=""
  
if [ "postgres" != "$LOGNAME" ]; then
   echo "Eseguire con utente postgres"
   exit
fi
 
if [ "x" == "x$CLIENTE" ] || [ "x" == "x$PRODOTTO" ]; then
   echo "Utilizzo: crea-utenza-app.sh [CLIENTE] [PRODOTTO] [AMBIENTE]"
   echo "Esempio: crea-utenza-app.sh amazon security prod"
   echo "Dove CLIENTE può essere : amazon security coll, ..."
   echo "Dove PRODOTTO può essere : security, humanresurce, ..."
   echo "Dove AMBIENTE può essere : prod, coll"
   exit
fi
 
### CONTROLLO AMBIENTE E COSTRUZIONE NOME DB e NOME RUOLO
 
if [ "$AMBIENTE" == "prod" ]; then
   DATABASE="${CLIENTE}_${PRODOTTO}"
   UTENZA="$CLIENTE"
elif [ "$AMBIENTE" == "coll" ]; then
   DATABASE="${CLIENTE}_${PRODOTTO}_${AMBIENTE}"
   UTENZA="${CLIENTE}_${AMBIENTE}"
else
   echo "Utilizzo: crea-utenza-app.sh [CLIENTE] [PRODOTTO] [AMBIENTE]"
   echo "Esempio: crea-utenza-app.sh banor pcp3 prod"
   echo "Dove CLIENTE può essere : amazon security coll, ..."
   echo "Dove PRODOTTO può essere : security, humanresurce, ..."
   echo "Dove AMBIENTE può essere : prod, coll"
   exit
fi
 
### SE UTENZA APP NON ESISTE LA CREO ALTRIMENTI ASSEGNO SOLO LE GRANT SUL DB INDICATO
num_userapp=`echo "SELECT count(*) FROM pg_user where usename = '$UTENZA'" | psql | awk 'NR==3 {print $1}'`
if [ "$num_userapp" == "0" ]; then
   echo "CREATE ROLE $UTENZA;" | psql
   echo "ALTER ROLE $UTENZA LOGIN;" | psql
   echo "assegnare una password all' utenza $UTENZA"
   echo "\password $UTENZA" | psql
   echo "Creazione utenza $UTENZA effettuata."
else
   echo "Utenza $UTENZA esistente e non ricreata."
fi
 
### ASSEGNAZIONE GRANT SUL DB INDICATO
 
echo "GRANT CONNECT ON DATABASE $DATABASE TO $UTENZA;" | psql
echo "GRANT CREATE ON SCHEMA public TO $UTENZA;" | psql -d $DATABASE
echo "GRANT USAGE ON SCHEMA public TO $UTENZA;" | psql -d $DATABASE
echo "Assegnati permessi connect e create all'utenza $UTENZA"
