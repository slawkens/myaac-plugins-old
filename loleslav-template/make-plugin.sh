#!/usr/bin/env bash
VERSION=`cat plugins/loleslav-template.json | jq -r '.version'`
NAME=myaac-loleslav-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.* -x "templates/loleslav/sources/bg03.psd"
