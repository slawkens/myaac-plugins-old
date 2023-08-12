#!/usr/bin/env bash
VERSION=`cat plugins/census.json | jq -r '.version'`
NAME=myaac-census-v$VERSION.zip
rm -f $NAME
zip -r $NAME system/ plugins/ -x */\.*
