#!/usr/bin/env bash
VERSION=`cat plugins/reborn-template.json | jq -r '.version'`
NAME=myaac-reborn-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
