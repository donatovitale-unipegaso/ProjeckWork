#!/bin/bash
 
USERAPP=$1
CLIENTE=$2
PRODOTTO=$3
AMBIENTE=$4
PERMISSI=$5
DATABASE=""
RUOLO=""
GRANTS=""
  
if [ "postgres" != "$LOGNAME" ]; then
   echo "Eseguire con utente postgres"
   exit
fi
 
 if [ "x" == "x$USERAPP" ] || [ "x" == "x$CLIENTE" ]  || [ "x" == "x$PRODOTTO" ]; then
   echo "Utilizzo: crea-role-crud-ro.sh [USERAPP] [CLIENTE] [PRODOTTO] [AMBIENTE] [PERMISSI]"
   echo "Esempio: crea-role-crud-ro.sh amazon amazon security prod crud"
   echo "Dove USERAPP può essere : amazon, nike, fiat, ..."
   echo "Dove CLIENTE può essere : amazon, nike, fiat, ..."
   echo "Dove PRODOTTO può essere : security, humanresurce, ..."
   echo "Dove AMBIENTE può essere : prod, coll"
   echo "Dove PERMISSI può essere: crud, ro"
   exit
fi
 
### CONTROLLO AMBIENTE E COSTRUZIONE NOME DB e NOME RUOLO
 
if [ "$AMBIENTE" == "prod" ]; then
   DATABASE="${CLIENTE}_${PRODOTTO}"
   RUOLO="${CLIENTE}_${PRODOTTO}_${PERMISSI}"
elif [ "$AMBIENTE" == "coll" ]; then
   DATABASE="${CLIENTE}_${PRODOTTO}_${AMBIENTE}"
   RUOLO="${CLIENTE}_${PRODOTTO}_${AMBIENTE}_${PERMISSI}"
 else
   echo "Utilizzo: crea-role-crud-ro.sh [USERAPP] [CLIENTE] [PRODOTTO] [AMBIENTE] [PERMISSI]"
   echo "Esempio: crea-role-crud-ro.sh amazon amazon security prod crud"
   echo "Dove USERAPP può essere : amazon, nike, fiat, ..."
   echo "Dove CLIENTE può essere : amazon, nike, fiat, ..."
   echo "Dove PRODOTTO può essere : security, humanresurce, ..."
   echo "Dove AMBIENTE può essere : prod, coll"
   echo "Dove PERMISSI può essere: crud, ro"
   exit
fi
 
 
##CREAZIONE RUOLI
if [ "$PERMISSI" == "crud" ] || [ "$PERMISSI" == "ro" ]; then
   echo "CREATE ROLE $RUOLO;" | psql
   echo "GRANT CONNECT ON DATABASE $DATABASE TO $RUOLO;" | psql
   echo "ALTER ROLE $RUOLO NOLOGIN;" | psql
   echo "Creazione ruolo $RUOLO effettuata."
   case $PERMISSI in
      crud)
         GRANTS="SELECT,INSERT,UPDATE,DELETE"
         ;;
      ro)
         GRANTS="SELECT"
         ;;
   esac
else
   echo "Utilizzo: crea-role-crud-ro.sh [USERAPP] [CLIENTE] [PRODOTTO] [AMBIENTE] [PERMISSI]"
   echo "Esempio: crea-role-crud-ro.sh amazon amazon security prod crud"
   echo "Dove USERAPP può essere : amazon, nike, fiat, ..."
   echo "Dove CLIENTE può essere : amazon, nike, fiat, ..."
   echo "Dove PRODOTTO può essere : security, humanresurce, ..."
   echo "Dove AMBIENTE può essere : prod, coll"
   echo "Dove PERMISSI può essere: crud, ro"
   exit
fi
 
  
## CONFIGURAZIONE PERMESSI DEI RUOLI
  
if [ "x" != "x$GRANTS" ]; then
   
   echo "ALTER DEFAULT PRIVILEGES FOR ROLE $USERAPP IN SCHEMA public GRANT $GRANTS on tables to $RUOLO;" | psql $DATABASE
   echo "Configurazione permessi del ruolo $RUOLO effettuata."
   
fi
