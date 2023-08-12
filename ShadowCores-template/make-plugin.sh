#!/usr/bin/env bash
VERSION=`cat plugins/ShadowCores-template.json | jq -r '.version'`
NAME=myaac-ShadowCores-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
