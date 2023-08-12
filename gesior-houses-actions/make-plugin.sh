#!/usr/bin/env bash
VERSION=`cat plugins/houses-actions.json | jq -r '.version'`
NAME=myaac-houses-actions-v$VERSION.zip
rm -f $NAME
zip -r $NAME plugins/ system/ images/ -x */\.*
