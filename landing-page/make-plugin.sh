#!/usr/bin/env bash
VERSION=`cat plugins/landing-page.json | jq -r '.version'`
NAME=myaac-landing-page-v$VERSION.zip
rm -f $NAME
zip -r $NAME landing/ plugins/ -x */\.*
