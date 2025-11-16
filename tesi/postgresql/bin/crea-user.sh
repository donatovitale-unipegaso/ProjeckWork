#!/bin/bash
UTENTE=$1
 
if [ "postgres" != "$LOGNAME" ]; then
   echo "Eseguire con utente postgres"
   exit
fi
if [ "x" == "x$UTENTE" ]; then
   echo "Utilizzo: crea-user.sh [UTENTE]"
   echo "Esempio: crea-user.sh donato_vitale"
   exit
fi
 
echo "CREATE ROLE $UTENTE;" |psql
echo "ALTER ROLE $UTENTE LOGIN;" | psql
 
echo "assegnare una password all'utente $UTENTE"
echo "\password $UTENTE" | psql
 
echo "Creazione utente $UTENTE effettuata."
