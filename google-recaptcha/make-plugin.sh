#!/usr/bin/env bash
VERSION=`cat plugins/google-recaptcha.json | jq -r '.version'`
NAME=myaac-google-recaptcha-v$VERSION.zip
rm -f $NAME
zip -r $NAME plugins/ -x */\.*
