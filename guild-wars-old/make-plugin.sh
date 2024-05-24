#!/usr/bin/env bash
VERSION=`cat plugins/guild-wars.json | jq -r '.version'`
NAME=myaac-guild-wars-v$VERSION.zip
rm -f $NAME
zip -r $NAME plugins/ system/ -x */\.*
