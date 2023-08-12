#!/usr/bin/env bash
VERSION=`cat plugins/start-countdown.json | jq -r '.version'`
NAME=myaac-start-countdown-v$VERSION.zip
rm -f $NAME
zip -r $NAME plugins/ -x */\.*
