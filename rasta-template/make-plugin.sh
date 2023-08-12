#!/usr/bin/env bash
VERSION=`cat plugins/rasta-template.json | jq -r '.version'`
NAME=myaac-rasta-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
