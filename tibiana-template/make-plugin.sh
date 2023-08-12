#!/usr/bin/env bash
VERSION=`cat plugins/tibiana-template.json | jq -r '.version'`
NAME=myaac-tibiana-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
