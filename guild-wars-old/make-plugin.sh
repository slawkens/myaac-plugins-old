#!/usr/bin/env bash
VERSION=`cat plugins/guild-wars-old.json | jq -r '.version'`
NAME=myaac-guild-wars-old-v$VERSION.zip
rm -f $NAME
zip -r $NAME plugins/ system/ -x */\.*
