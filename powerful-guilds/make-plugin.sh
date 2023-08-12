#!/usr/bin/env bash
VERSION=`cat plugins/powerful-guilds.json | jq -r '.version'`
NAME=myaac-powerful-guilds-v$VERSION.zip
rm -f $NAME
zip -r $NAME plugins/ -x */\.*
