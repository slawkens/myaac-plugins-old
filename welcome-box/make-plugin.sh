#!/usr/bin/env bash
VERSION=`cat plugins/welcome-box.json | jq -r '.version'`
NAME=myaac-welcome-box-v$VERSION.zip
rm -f $NAME
zip -r $NAME plugins/ -x */\.*
