#!/usr/bin/env bash
VERSION=`cat plugins/better-downloads-page.json | jq -r '.version'`
NAME=myaac-better-downloads-page-v$VERSION.zip
rm -f $NAME
zip -r $NAME plugins/ system/ -x */\.*
