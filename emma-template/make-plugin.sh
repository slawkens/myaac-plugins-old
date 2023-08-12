#!/usr/bin/env bash
VERSION=`cat plugins/emma-template.json | jq -r '.version'`
NAME=myaac-emma-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
