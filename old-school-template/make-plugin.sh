#!/usr/bin/env bash
VERSION=`cat plugins/old-school-template.json | jq -r '.version'`
NAME=myaac-old-school-template-v$VERSION.zip
rm -f $NAME
zip -r $NAME templates/ plugins/ -x */\.* -x "templates/old-school/images/bg.psd"
