#!/usr/bin/env bash
VERSION=`cat plugins/atomio-template.json | jq -r '.version'`
NAME=myaac-atomio-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.* -x "templates/old-school/images/bg.psd"
