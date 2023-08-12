#!/usr/bin/env bash
VERSION=`cat plugins/telara-template.json | jq -r '.version'`
NAME=myaac-telara-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
