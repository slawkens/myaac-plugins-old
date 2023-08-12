#!/usr/bin/env bash
VERSION=`cat plugins/trees-template.json | jq -r '.version'`
NAME=myaac-trees-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
