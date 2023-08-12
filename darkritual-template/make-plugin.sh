#!/usr/bin/env bash
VERSION=`cat plugins/darkritual-template.json | jq -r '.version'`
NAME=myaac-darkritual-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
