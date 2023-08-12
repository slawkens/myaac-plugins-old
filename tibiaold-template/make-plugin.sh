#!/usr/bin/env bash
VERSION=`cat plugins/tibiaold-template.json | jq -r '.version'`
NAME=myaac-tibiaold-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
