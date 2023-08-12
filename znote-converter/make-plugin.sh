#!/usr/bin/env bash
VERSION=`cat plugins/znote-converter.json | jq -r '.version'`
NAME=myaac-znote-converter-v$VERSION.zip
rm -f $NAME
zip -r $NAME system/ plugins/ -x */\.*
