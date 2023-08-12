#!/usr/bin/env bash
VERSION=`cat plugins/semantic-template.json | jq -r '.version'`
NAME=myaac-semantic-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.*
