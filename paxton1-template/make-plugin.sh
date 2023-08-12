#!/usr/bin/env bash
VERSION=`cat plugins/paxton1-template.json | jq -r '.version'`
NAME=myaac-paxton1-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
