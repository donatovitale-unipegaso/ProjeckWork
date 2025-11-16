#!/bin/bash
 
CLIENTE=$1
PRODOTTO=$2
AMBIENTE=$3
DATABASE=""
 
if [ "postgres" != "$LOGNAME" ]; then
    echo "Eseguire con utente postgres"
    exit
fi
 
if [ "x" == "x$CLIENTE" ] || [ "x" == "x$PRODOTTO" ]; then
    echo "Utilizzo: crea-db.sh [CLIENTE] [PRODOTTO] [AMBIENTE]"
    echo "Esempio: crea-db.sh amazon security coll"
    echo "Dove CLIENTE può essere : amazon, nike, fiat, ..."
    echo "Dove PRODOTTO può essere : security, humanresurce, ..."
    echo "Dove AMBIENTE può essere : prod, coll"
    exit
fi
 
### CONTROLLO AMBIENTE E COSTRUZIONE NOME DB
 
if [ "$AMBIENTE" == "prod" ]; then
    DATABASE="${CLIENTE}_${PRODOTTO}"
elif [ "$AMBIENTE" == "coll" ]; then
    DATABASE="${CLIENTE}_${PRODOTTO}_${AMBIENTE}"
else
    echo "Utilizzo: crea-db.sh [CLIENTE] [PRODOTTO] [AMBIENTE]"
    echo "Esempio: crea-db.sh amazon security coll"
    echo "Dove CLIENTE può essere : amazon, nike, fiat, ..."
    echo "Dove PRODOTTO può essere : security, humanresurce, ..."
    echo "Dove AMBIENTE può essere : prod, coll"
    exit
fi
 
### CREAZIONE DATABASE
 
echo "CREATE DATABASE $DATABASE;" | psql
echo "REVOKE CONNECT ON DATABASE $DATABASE FROM PUBLIC;" | psql
echo "REVOKE CREATE ON SCHEMA public FROM PUBLIC;" | psql -d $DATABASE
 
echo "Creazione database $DATABASE effettuata."
