#!/usr/bin/env bash
VERSION=`cat plugins/aldora-template.json | jq -r '.version'`
NAME=myaac-aldora-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
