#!/usr/bin/env bash
VERSION=`cat plugins/coffee-n-cream-template.json | jq -r '.version'`
NAME=myaac-coffee-n-cream-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
