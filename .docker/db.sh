#!/usr/bin/env bash

if [ -f "data/neo4j.dump" ]; then
    echo "Importing neo4j dump..."
    bin/neo4j-admin database load --overwrite-destination=true --from-path=data neo4j && rm data/neo4j.dump
fi

find labs -name "apoc*.jar" -exec "mv" "{}" "plugins/" ";"

echo "Starting database..."
tini -g -- /startup/docker-entrypoint.sh neo4j
