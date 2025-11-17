#!/bin/bash
set -e

echo ">>> Applying custom pg_hba.conf"

PGDATA="${PGDATA:-/var/lib/postgresql/data}"

cp /docker-entrypoint-initdb.d/pg_hba.conf "$PGDATA/pg_hba.conf"
chown postgres:postgres "$PGDATA/pg_hba.conf"

echo ">>> Custom pg_hba.conf applied"

